<template>
    <div class="container">
        <div class="row">

        <span class="green-text text-darken-2">
            <h5>Minhas contas bancárias</h5>
        </span>

            <div class="card-panel z-depth-5">
                <table class="bordered striped hightlight responsive-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Agência</th>
                        <th>C/C</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(index,o) in bankAccounts">
                        <td>&nbsp;{{o.id}}</td>
                        <td>{{o.name}}</td>
                        <td>{{o.agency}}</td>
                        <td>{{o.account}}</td>
                        <td>
                            <a v-link="{name: 'bank-account.update', params: {id: o.id} }">Editar</a>
                            <a href="#" @click.prevent="openModalDelete(o)">Excluir</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <pagination :current-page.sync="pagination.current_page" :per-page="pagination.per_page"
                            :total-records="pagination.total"></pagination>
            </div>

            <div class="fixed-action-btn">
                <a class="btn-floating btn-large" v-link="{name: 'bank-account.create'}">
                    <i class="large material-icons">add</i>
                </a>
            </div>
        </div>
    </div>
    <modal :modal="modal">
        <div slot="content" v-if="bankAccountToDelete">
            <h4>Mensagem de confirmação</h4>
            <p><strong>Deseja excluir esta conta bancária?</strong></p>
            <div class="divider"></div>
            <p>Nome: <strong>{{bankAccountToDelete.name}}</strong></p>
            <p>Agência: <strong>{{bankAccountToDelete.agency}}</strong></p>
            <p>C/C: <strong>{{bankAccountToDelete.account}}</strong></p>
            <div class="divider"></div>
        </div>
        <div slot="footer">
            <button class="btn btn-flat waves-effect green lighten-2 modal-close modal-action" @click="destroy()">Ok</button>
            <button class="btn btn-flat waves-effect waves-red modal-close modal-action">Cancelar</button>
        </div>
    </modal>
</template>
<script>
    import {BankAccount} from '../../services/resources';
    import ModalComponent from '../../../../_default/components/Modal.vue';
    import PaginationComponent from '../Pagination.vue';
    export default{
        components: {
            'modal': ModalComponent,
            'pagination': PaginationComponent,
        },
        data(){
            return {
                bankAccounts: [],
                bankAccountToDelete: null,
                modal: {
                    id: "modal-delete"
                },
                pagination: {
                    current_page: 0,
                    per_page: 0,
                    total: 0
                },
                search: '',
                order: {
                    key: 'id',
                    sort: 'asc'
                },
                table: {
                    headers: {
                        id: {
                            label: '#', width: '7%'
                        },
                        name: {
                            label: 'Nome', width: '30%'
                        },
                        agency: {
                            label: 'Agência', width: '13%'
                        },
                        account: {
                            label: 'C/C', width: '13%'
                        },
                        'banks:bank_id|banks.name': {
                            label: 'Banco', width: '17%'
                        },
                        'default': {
                            label: 'Padrão', width: '5%'
                        }
                    }
                }
            }
        },
        created(){
            this.getBankAccounts();
        },
        methods: {
            destroy(){
                BankAccount.delete({id: this.bankAccountToDelete.id}).then((response) => {
                    this.bankAccounts.$remove(this.bankAccountToDelete);
                    this.bankAccountToDelete = null;
                    if (this.bankAccounts.length === 0 && this.pagination.current_page > 0) {
                        this.pagination.current_page--;
                    }
                    Materialize.toast('Conta bancária excluída com sucesso', 4000);
                });
            },
            openModalDelete(bankAccount){
                this.bankAccountToDelete = bankAccount;
                $('#modal-delete').modal('open');
            },
            getBankAccounts(){
                BankAccount.query({
                    page: this.pagination.current_page + 1,
                    orderBy: this.order.key,
                    sortedBy: this.order.sort,
                    search: this.search,
                    include: 'bank'
                }).then((response) => {
                    this.bankAccounts = response.data.data;
                    let pagination = response.data.meta.pagination;
                    pagination.current_page--;
                    this.pagination = pagination;
                });
            },
            sortBy(key){
                this.order.key = key;
                this.order.sort = this.order.sort == 'desc' ? 'asc' : 'desc';
                this.getBankAccounts();
            },
            filter(){
                this.pagination.current_page = 0;
                this.getBankAccounts();
            }
        },
        events: {
            'pagination::changed'(page){
                this.getBankAccounts();
            }
        }
    }
</script>
