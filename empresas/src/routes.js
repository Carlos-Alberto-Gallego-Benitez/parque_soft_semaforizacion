export const routes = [{
        path: '/',
        name: 'base',
        component: () =>
            import ('./views/Landing')
    },
    {
        path: '/home',
        name: 'home',
        component: () =>
            import ('./views/Home')
    },
    {
        path: '/login',
        name: 'login',
        component: () =>
            import ('./views/Login')
    },
    {
        path: '/registro',
        name: 'registro',
        component: () =>
            import ('./views/Register')
    },
    {
        path: '/perfil',
        name: 'perfil',
        component: () =>
            import ('./views/perfil/create')
    },
    {
        path: '/formularios',
        name: 'formularios',
        component: () =>
            import ('./views/formularios/index')
    },
    {
        path: '/formularios/:id',
        name: 'formularios.empresa',
        component: () =>
            import ('./views/formularios/create')
    },
    {
        path: '/resultados-formularios-empresa/:id_formulario/:id_user',
        name: 'resultados.formularios.empresa',
        component: () =>
            import ('./views/resultados/index')
    },

    //rutas nuevas
    {
        path: '/listado-formularios',
        name: 'listado.formularios',
        component: () =>
            import ('./views/formulariosSeccion/index')
    },

    {
        path: '/formularios-empresa/:id',
        name: 'formularios.empresa.s',
        component: () =>
            import ('./views/formulariosSeccion/create')
    },
    {
        path: '/resultados-form-empresa/:id_formulario/:id_user',
        name: 's.resultados.formularios.empresa',
        component: () =>
            import ('./views/resultados/result')
    },
]