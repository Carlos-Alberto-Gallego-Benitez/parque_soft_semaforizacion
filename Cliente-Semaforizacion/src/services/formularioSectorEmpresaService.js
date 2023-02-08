import Service from "./Service";
const baseurl = '/api/formularios-sector';
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
    showByIdFormulario(id) {
        return Service.get(`${baseurl}/show-by-idFormulario/${id}`);
    },
    showByIdSector(id) {
        return Service.get(`${baseurl}/show-by-idSector/${id}`);
    },

    update(obj) {
        return Service.put(`${baseurl}/update`, obj);
    },
    delete(id) {
        return Service.delete(`${baseurl}/delete/${id}`);
    },
}