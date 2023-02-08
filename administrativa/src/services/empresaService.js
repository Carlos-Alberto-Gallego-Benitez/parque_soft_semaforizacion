import Service from "./Service";
const baseurl = '/api/empresa';
export default {
    index(params = {}) {
        return Service.get(`${baseurl}`, {
            params: params,
        });
    },
    store(obj) {
        return Service.post(`${baseurl}/store`, obj);
    },
    show(id) {
        return Service.get(`${baseurl}/show/${id}`);
    },
    showByIdUser(id) {
        return Service.get(`${baseurl}/show-by-idUSer/${id}`);
    },
    update(obj) {
        return Service.put(`${baseurl}/update`, obj);
    },
    delete(id) {
        return Service.delete(`${baseurl}/delete/${id}`);
    },
}