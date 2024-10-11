<template>

    <div class="modal fade" id="categoria-form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Formulário de categoria</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nome:</label>
                            <input type="text" class="form-control" v-model="form.nome" >
                            <div v-if="errors"> 
                            {{errors}} 
                            </div>
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
export default {
    props: ['selected'],
    data() {
        return {
            form: {
                nome: null,
                _method: 'post'
            },
            errors: null,
            
        }
    },
    watch: {
        selected(value) {
            if(value) {
                this.form.nome = value.nome
                this.form.id = value.id
                this.form._method =  'put'
            }else {
                this.clear()
            }
        }
    },
    methods: {
        save() {
            axios.post(`/categorias${this.form && this.form.id ? `/${this.form.id}` : ''}`, this.form).then(res => {
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
            this.form._method = 'post'
            this.form.id = null
        }
    }
}
</script>

<style>

</style>