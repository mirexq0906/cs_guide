import {createStore} from 'vuex'


const store = createStore({
    state() {
        return {
            menuItems: []
        }
    },
    mutations: {
        setMenuItems(state, data) {
            state.menuItems = data
        }
    }
})

export default store;
