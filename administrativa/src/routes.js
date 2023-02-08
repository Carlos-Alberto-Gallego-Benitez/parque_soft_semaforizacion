export const routes = [{
        path: '/login',
        name: 'login',
        component: () =>
            import ('./views/Login')
    },
    {
        path: '/',
        name: 'home',
        component: () =>
            import ('./views/home')
    },
    {
        path: '/signup',
        name: 'signup',
        component: () =>
            import ('./views/Register')
    },
    {
        path: '/sector-empresa',
        name: 'sector.empresa',
        component: () =>
            import ('./views/empresas/sectores/create')
    },
    {
        path: '/etapas',
        name: 'etapas',
        component: () =>
            import ('./views/etapas/create')
    },
    {
        path: '/usuarios',
        name: 'usuarios',
        component: () =>
            import ('./views/usuarios/create')
    },
    {
        path: '/configuracion-formularios',
        name: 'configuracion.formularios',
        component: () =>
            import ('./views/baseFormulario/formularios/create')
    },
    {
        path: '/configuracion-preguntas-formularios/:id',
        name: 'preguntas.formularios',
        component: () =>
            import ('./views/baseFormulario/preguntas/create')
    },
    {
        path: '/configuracion-sectores-formularios/:id',
        name: 'sectores.formularios',
        component: () =>
            import ('./views/baseFormulario/sectoresFormularios/create')
    },
    {
        path: '/listado-empresas',
        name: 'listado.empresas',
        component: () =>
            import ('./views/empresas/listado/create')
    },
    {
        path: '/resultados-empresa/:id',
        name: 'resultados.empresa',
        component: () =>
            import ('./views/resultados/index')
    },
    {
        path: '/empresas-formularios/:id',
        name: 'empresas.formularios',
        component: () =>
            import ('./views/empresas/listado/empresasFormularios')
    },

    {
        path: '/resultados-formularios-empresa/:id/:id_user',
        name: 'resultados.formularios.empresa',
        component: () =>
            import ('./views/resultados/index')
    },
    {
        path: '/grafico',
        name: 'grafico',
        component: () =>
            import ('./views/grafico/index')
    },

    {
        path: '/grafico-formulario/:id',
        name: 'grafico.formulario',
        component: () =>
            import ('./views/grafico/graficoFormulario')
    },
    {
        path: '/listado-formularios',
        name: 'listado.formularios',
        component: () =>
            import ('./views/grafico/index')
    },
    //nuevas rutas
    {
        path: '/config-formularios',
        name: 'config.formularios',
        component: () =>
            import ('./views/baseFormulariosSeccion/formularios/create')
    },
    {
        path: '/config-sectores-formularios/:id',
        name: 'sectores.formularios.s',
        component: () =>
            import ('./views/baseFormulariosSeccion/sectoresFormularios/create')
    },
    {
        path: '/config-secciones-formularios/:id',
        name: 'secciones.formularios',
        component: () =>
            import ('./views/baseFormulariosSeccion/secciones/create')
    },
    {
        path: '/config-preguntas-formularios/:id_seccion/:id_formulario',
        name: 'config.preguntas.formularios',
        component: () =>
            import ('./views/baseFormulariosSeccion/preguntas/create')
    },
    {
        path: '/resultados-form-empresa/:id_formulario/:id_user',
        name: 's.resultados.formularios.empresa',
        component: () =>
            import ('./views/resultados/result')
    },
    {
        path: '/grafico-formulario/:id',
        name: 'grafico.general.formulario',
        component: () =>
            import ('./views/grafico/graficoFormulario')
    },
]