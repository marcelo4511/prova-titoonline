<template>
    <div class="container m-3">
        <div class="d-flex justify-content-between">
            <h3>Produtos</h3>
            <div>

                <button 
                    class="btn btn-sn btn-success me-1" data-bs-toggle="modal" 
                    data-bs-target="#produto-form" 
                    @click="show(null)"
                >
                Novo produto</button>
                <button class="btn btn-sn btn-success me-1" @click="txt(null)">TXT</button>
                <button class="btn btn-sn btn-success me-1" @click="excel()">EXCEL</button>
                <button class="btn btn-sn btn-success" @click="pdf()">PDF</button>
            </div>

        </div>

        <table class="table" v-if="produtos.length > 0">
            <thead>
                <tr>
                    <th scope="col">Categoria</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Descriçao</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Acões</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="produto in produtos" :key="produto.id">
                    <td>{{produto && produto.categoria ? produto.categoria.nome: ''}}</td>
                    <td>{{produto.nome}}</td>
                    <td>{{produto.descricao}}</td>
                    <td>{{produto.price}}</td>

                    <td>
                        <button class="btn btn-sm btn-primary me-2" 
                            data-bs-toggle="modal" 
                            data-bs-target="#produto-form" 
                            @click="show(produto)"
                            >Editar
                        </button>
                        <button 
                            class="btn btn-sm btn-danger" 
                            data-bs-toggle="modal" 
                            data-bs-target="#product-delecao-form" 
                            @click="show(produto)"
                            >Deletar
                        </button>

                    </td>
                </tr>
            </tbody>
        </table>
        <div v-else>
            <div class="alert alert-warning mt-2">Não há produtos neste estoque</div>
        </div>
        <product-form 
            :selected="selected" 
            @store="store" 
            @update="update"
        ></product-form>
    

        <product-delete    
            :selected="selected" 
            @destroy="deleteproduct" 
        ></product-delete>
    </div>
</template>

<script>
import axios from 'axios'
import ProductForm from './ProductForm.vue'
import ProductDelete from './ProductDelete.vue'
export default {
    components: { ProductForm, ProductDelete },
    data(){
        return {
            selected: null,
            produtos: []
        }
    },

    async created() {
        await this.getprodutos()
    },

    methods: {
         getprodutos() {
            axios.get('/produtos/get').then(res => {
                this.produtos = res.data
            })
        },
        
        closeModal(idModal){
            var myModalEl = document.getElementById(idModal);
            var modal = bootstrap.Modal.getInstance(myModalEl)
            modal.hide();
        },

        store($event) {
            this.produtos.push($event)
            this.closeModal('produto-form')
        },
        
        show(produto) {
            this.selected = produto
        },

        update($event) {
            let indexproduto = this.produtos.findIndex(produto => produto.id == $event.id)
            this.produtos[indexproduto] = $event
            this.closeModal('produto-form')
        },
        deleteproduct($event) {
            let indexproduto = this.produtos.findIndex(produto => produto.id == $event.id)
            this.produtos.splice(indexproduto, 1)
            this.closeModal('product-delecao-form')
        },
        excel(){

            axios.get(`/produtos/excel`,{responseType: 'blob' }).then((response) => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'produtos.xlsx'); 
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            })
        },
        pdf(){

            axios.get(`/produtos/pdf`,{responseType: 'blob' }).then((response) => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'produtos.pdf'); 
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            })
        },
        txt(){

            axios.get(`/produtos/txt`,{responseType: 'blob' }).then((response) => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'produtos.txt'); 
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            })
        }
    },

   
}
</script>

<style>

</style>