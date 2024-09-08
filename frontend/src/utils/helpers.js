export const debounce = (fn, delay) => {
  let timeout
  return function (...args) {
    clearTimeout(timeout)
    timeout = setTimeout(() => fn.apply(this, args), delay)
  }
}

export const now = () => new Date().toISOString().split('T')[0]

export const getValue = (item, column) => {
  if (!item || !column || !column.key) return 'N/A'

  const value = column.key.split('.').reduce((acc, part) => {
    const arrayMatch = part.match(/(\w+)\[(\d+)\]/)
    if (arrayMatch) {
      const arrayKey = arrayMatch[1]
      const index = parseInt(arrayMatch[2], 10)
      if (acc && Array.isArray(acc[arrayKey])) {
        return acc[arrayKey][index] !== undefined ? acc[arrayKey][index] : 'N/A'
      }
      return 'N/A'
    }
    if (acc && acc[part] !== undefined) {
      return acc[part]
    }
    return 'N/A'
  }, item)

  if (column.rounding) {
    if (typeof value === 'number') return value.toFixed(2)
    if (typeof value === 'string') return parseFloat(value).toFixed(2)
  }

  return value
}

export const getValueDetailsCardComponent = (key, data) => {
  return key.split('.').reduce((o, i) => {
    if (o === undefined || o === null) return null

    // Check if `i` is an array index
    const arrayIndexMatch = i.match(/^(\w+)\[(\d+)\]$/)
    if (arrayIndexMatch) {
      const arrayKey = arrayIndexMatch[1]
      const index = parseInt(arrayIndexMatch[2], 10)
      o = o[arrayKey]
      return Array.isArray(o) && index < o.length ? o[index] : null
    }

    return o && o[i] !== undefined ? o[i] : null
  }, data)
}
