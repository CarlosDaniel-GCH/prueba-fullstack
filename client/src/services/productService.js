const API_URL = "http://localhost:8000/api/product";

export const productService = {
    async getAll() {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error("Error al obtener productos");
        const data = await response.json();
        return data.data;
    },

    async create(product) {
        return await fetch(API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(product)
        });
    },

    async update(id, product) {
        return await fetch(`${API_URL}/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(product)
        });
    },

    async delete(id) {
        return await fetch(`${API_URL}/${id}`, {
            method: 'DELETE'
        });
    }
};