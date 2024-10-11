<template>

    <div class="modal fade" id="produto-form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Formulário de produto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Categoria:</label>

                            <select class="form-select" aria-label="Default select example" v-model="form.categoria_id">
                                <option :value="categoria.id" v-for="categoria in categorias" :key="categoria.id">{{categoria.nome}}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nome:</label>
                            <input type="text" class="form-control" v-model="form.nome" >
                            <div v-if="errors"> 
                            {{errors}} 
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Descrição:</label>
                            <textarea class="form-control" placeholder="digite uma descrição para o seu produto" v-model="form.descricao"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Preço:</label>

                                <money3
                                    v-model="form.preco"
                                    v-bind="{
                                    prefix: 'R$ ',
                                    suffix: '',
                                    thousands: '.',
                                    decimal: ',',
                                    precision: 2,
                                    
                                    }"
                                    class="form-control"
                                />
                            
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="save">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
  import { Money3Component } from 'v-money3'
export default {
    props: ['selected'],
   components: { money3: Money3Component },
       data() {
        return {
            form: {
                nome: null,
                descricao: null,
                preco: 0,
                categoria_id: null,
                _method: 'post'
            },
          
            errors: null,
            categorias: []
        }
    },
    watch: {
        selected(value) {
            if(value) {
                this.form.preco = value.preco
                this.form.descricao = value.descricao
                this.form.categoria_id = value.categoria_id

                this.form.nome = value.nome
                this.form.id = value.id
                this.form._method =  'put'
            }else {
                this.clear()
            }
        }
    },
    created(){
        axios.get('/categorias/get').then(res => {
            this.categorias = res.data
        })
    },
    methods: {
        save() {
            axios.post(`/produtos${this.form && this.form.id ? `/${this.form.id}` : ''}`, this.form).then(res => {
                if(res.status == 201) {
                    this.$emit('store', res.data)
                }
                if(res.status == 200) {
                    this.$emit('update', res.data)
                    
                }
                this.clear()
            }).catch(error => {
                if(error) {
                    if(error.status == 422) {
                        this.errors = error.response.data.message
                    }
                }
            })
        },

        clear() {
            this.form.nome = null,
            this.form.descricao = null,
            this.form.categoria_id = null,
            this.form.preco = null,

            this.form._method = 'post'
            this.form.id = null
        }
    }
}
</script>

<style>

</style>