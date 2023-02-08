import { createStore } from "vuex";
import { login, logout, getAuthenticatedUser, csrfCookie } from "../services/AuthService";

const store = createStore({
    state: {
        layout: 'Loading',
        user: null,
        is_logged: '',
        spinner: false
    },
    mutations: {
        SET_LAYOUT(state, newLayout) {
            state.layout = newLayout
        },
        SET_LOGIN_STATE(state, loginState) {
            state.is_logged = loginState;
        },
        SET_LOGIN_USER(state, user) {
            state.user = user;
        },
        SET_SPINNER_STATE(state, spinner) {
            state.spinner = spinner;
        }
    },
    actions: {
        async login({ commit }, credentials) {
            try {
                await csrfCookie();
                const userCredentials = await login(credentials);
                commit('SET_LOGIN_USER', userCredentials.data);
                commit('SET_LAYOUT', 'AppLayout');
                commit('SET_LOGIN_STATE', true);
            } catch (e) {
                throw {
                    'status': e.response.status,
                    'error': e.response.error
                }
            }
        },
        async logout({ commit }) {
            await logout();
            commit('SET_LOGIN_USER', null);
            commit('SET_LAYOUT', 'LandingPageLayout');
            commit('SET_LOGIN_STATE', false);
        },
        async currentUser({ commit }) {
            try {

                let response = await getAuthenticatedUser();

                if (response.data) {
                    commit('SET_LOGIN_USER', response.data);
                    commit('SET_LAYOUT', 'AppLayout');
                    commit('SET_LOGIN_STATE', true);
                } else {
                    commit('SET_LOGIN_STATE', false);
                    commit('SET_LAYOUT', 'LandingPageLayout');
                }

            } catch (e) {
                switch (e.response.status) {
                    case 401:
                        commit('SET_LOGIN_USER', {});
                        commit('SET_LOGIN_STATE', false);
                        commit('SET_LAYOUT', 'LandingPageLayout');
                        break;
                }
            }

        },
        showSpinner({ commit }) {
            commit('SET_SPINNER_STATE', true)
        },
        hideSpinner({ commit }) {
            commit('SET_SPINNER_STATE', false)
        }
    }
});

export default store;