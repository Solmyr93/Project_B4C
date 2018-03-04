export default {

    get(key) {
        return sessionStorage.getItem(key) ? sessionStorage.getItem(key) : null
    },

    set(key, val) {
        sessionStorage.setItem(key, val)
    },

    remove(key) {
        sessionStorage.removeItem(key)
    },

}
