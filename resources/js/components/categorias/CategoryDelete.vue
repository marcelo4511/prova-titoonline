<template>
   

    <div class="modal fade" id="category-delecao-form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Deseja deletar esse categoria ?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="destroy">Deletar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    props: ['selected'],
    methods: {
         destroy() {
            axios.delete(`/categorias/${this.selected.id}`).then(res => {
                if(res.status == 200) {
                    this.$emit('destroy', res.data)
                }
                
            }).catch(error => {
                if(error) {
                    if(error.status == 422) {
                        this.errors = error.response.data.message
                    }
                }
            })
        },

    }
}
</script>

<style>

</style>