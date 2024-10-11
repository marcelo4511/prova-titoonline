<template>
    <div class="container m-3">
        <div class="d-flex justify-content-between">
            <h3>Categorias</h3>
            <button class="btn btn-sn btn-success" data-bs-toggle="modal" data-bs-target="#categoria-form" @click="show(null)">Nova Categoria</button>

        </div>

        <table class="table" v-if="categorias.length > 0">
            <thead>
                <tr>
                <th scope="col">Nome</th>
                <th scope="col">Acões</th>
             
                </tr>
            </thead>
            <tbody>
                <tr v-for="categoria in categorias" :key="categoria.id">
                    <td>{{categoria.nome}}</td>
                    <td>
                        <button class="btn btn-sm btn-primary me-2" 
                            data-bs-toggle="modal" 
                            data-bs-target="#categoria-form" 
                            @click="show(categoria)"
                            >Editar
                        </button>
                        
                        <button 
                            class="btn btn-sm btn-danger" 
                            data-bs-toggle="modal" 
                            data-bs-target="#category-delecao-form" 
                            @click="show(categoria)"
                            >Deletar
                        </button>

                    </td>
                </tr>
            </tbody>
        </table>
        <div v-else>
            <div class="alert alert-warning mt-2">Não há categorias neste estoque</div>
        </div>
        <category-form 
            :selected="selected" 
            @store="store" 
            @update="update"
        ></category-form>
    

        <category-delete    
            :selected="selected" 
            @destroy="deleteCategory" 
        ></category-delete>
    </div>
</template>

<script>
import axios from 'axios'
import CategoryForm from './CategoryForm.vue'
import CategoryDelete from './CategoryDelete.vue'
export default {
    components: { CategoryForm, CategoryDelete },
    data(){
        return {
            selected: null,
            categorias: []
        }
    },

    async created() {
        await this.getCategorias()
    },
    show(produto) {
        this.selected = produto
    },
    methods: {
         getCategorias() {
            axios.get('/categorias/get').then(res => {
                this.categorias = res.data
            })
        },

        closeModal(idModal){
            var myModalEl = document.getElementById(idModal);
            var modal = bootstrap.Modal.getInstance(myModalEl)
            modal.hide();
        },

        store($event) {
            this.categorias.push($event)
            this.closeModal('categoria-form')
        },
        show(categoria) {
            this.selected = categoria
        },

        update($event) {
            let indexCategoria = this.categorias.findIndex(categoria => categoria.id == $event.id)
            this.categorias[indexCategoria] = $event
            this.closeModal('categoria-form')
        },
        deleteCategory($event) {
            let indexCategoria = this.categorias.findIndex(categoria => categoria.id == $event.id)
            this.categorias.splice(indexCategoria, 1)
            this.closeModal('category-delecao-form')
        },
    }
}
</script>

<style>

</style>