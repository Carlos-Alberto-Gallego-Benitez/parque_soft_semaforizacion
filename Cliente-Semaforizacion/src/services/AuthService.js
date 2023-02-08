import Service from "./Service";

export function csrfCookie(){
    return Service.get('sanctum/csrf-cookie');
}

export function login(credentials){
    return Service.post('/login', credentials);
}

export function getAuthenticatedUser(){
    return Service.get('/api/user');
}

export function logout(){
    return Service.post('/logout', null);
}

export function createUser(email, password){
    return `${email} ${password}`
}

