const API_URL = "http://localhost:8000/api/category";

export const categoryService = {
    async getAll() {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error("Error al obtener las categorias");
        const data = await response.json();
        return data.data;
    },

    async create(category) {
        return await fetch(API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(category)
        });
    },

    async update(id, category) {
        return await fetch(`${API_URL}/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(category)
        });
    },

    async delete(id) {
        return await fetch(`${API_URL}/${id}`, {
            method: 'DELETE'
        });
    }
};