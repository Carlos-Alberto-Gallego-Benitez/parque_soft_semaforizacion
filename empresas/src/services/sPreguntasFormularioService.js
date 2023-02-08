import Service from "./Service";
const baseurl = '/api/config-preguntas-formularios';
export default {
    index() {
        return Service.get(`${baseurl}`);
    },
    store(obj) {
        return Service.post(`${baseurl}/store`, obj);
    },
    show(id) {
        return Service.get(`${baseurl}/show/${id}`);
    },
    showByForm(id) {
        return Service.get(`${baseurl}/show-by-form/${id}`);
    },
    showByIdSeccion(id) {
        return Service.get(`${baseurl}/show-by-idSeccion/${id}`);
    },
    update(obj) {
        return Service.put(`${baseurl}/update`, obj);
    },
    delete(id) {
        return Service.delete(`${baseurl}/delete/${id}`);
    },
}