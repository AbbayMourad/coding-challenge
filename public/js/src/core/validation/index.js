function isDefined(value) {
  return ![null, undefined].includes(value)
}

function validateObj({ obj = {}, schema = {} }) {
  const errors = {}
  for (const field in schema) {
    const constraints = schema[field]
    const value = obj[field]
    const validation = validate({ constraints, value }) || {}
    if (!validation.failed) continue
    const { failed } = validation
    errors[field] = getErrMess({ failedConstraint: failed, values: { ...validation, field } })
  }
  return errors
}

function validate({ constraints, value }) {
  if (!constraints) return
  if (constraints.optional && !value) return
  if (!value) return { failed: 'required' }
  if (constraints.number && Number.isNaN(Number.parseFloat(value))) return { failed: 'number' }
  if (isDefined(constraints.min) && Number.parseFloat(value) < constraints.min)
    return { failed: 'min', min: constraints.min }
  if (isDefined(constraints.maxLength) && value && value.length > constraints.maxLength)
    return { failed: 'maxLength', maxLength: constraints.maxLength }
}

const errMess = {
  required: '{field} is required',
  number: '{field} must be a number',
  min: '{field} value must be at least {min}',
  maxLength: '{field} length must be at max {maxLength}'
}

function getErrMess({ failedConstraint, values }) {
  const genericErrMess = errMess[failedConstraint] || ''
  // replace placeholders: {xxx} -> values[xxx]
  return genericErrMess.replace(/{([^}]+)}/g, (match, p1) => values[p1])
}

module.exports = { validateObj }