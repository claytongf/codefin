<template>
    <ul :id="o.id" class="dropdown-content" v-for="o in config.menusDropdown">
        <li v-for="item in o.items">
            <a :href="item.url">{{ item.name }}</a>
        </li>
    </ul>
    <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper container">
                <a href="#" class="right brand-logo">Code Contas</a>
                <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
                <ul class="left hide-on-med-and-down">
                    <li v-for="o in config.menus">
                        <a href="!#" v-if="o.dropdownId" class="dropdown-button" :data-activates="o.dropdownId">{{ o.name }} <i class="material-icons right">arrow_drop_down</i> </a>
                        <a v-else :href="o.url">{{ o.name }}</a>
                    </li>
                </ul>
                <ul id="nav-mobile" class="side-nav">
                    <li v-for="o in config.menus">
                        <a href="#" :href="o.url">{{ o.name }}</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!--<modal></modal>-->
    <!--<router-view></router-view>-->
</template>
<script type="text/javascript">
    export default {
        props: {
            config: {
                type: Object,
                default(){
                    return{
                        name: '',
                        menus: [],
                        menusDropdown: [],
                        urlLogout: '/admin/logout'
                    }
                }
            }
        },
        ready(){
            $('.button-collapse').sideNav();
            $('.dropdown-button').dropdown();
        },
        data(){
            return {
                menus: [
                    {id: 0, name: "Dashboard", routeName: 'bill.dashboard'},
                    {name: "Contas a pagar", routeName: 'bill-pay.list', dropdownId: 'bill-pay'},
                    {name: "Contas a receber", routeName: 'bill-receive.list', dropdownId: 'bill-receive'}
                ],
                menusDropdown: [
                    {
                        id: 'bill-pay', items: [
                        {id: 0, name: "Listar contas", routeName: 'bill-pay.list'},
                        {id: 1, name: "Criar conta", routeName: 'bill-pay.create'}
                    ]
                    },
                    {
                        id: 'bill-receive', items: [
                        {id: 0, name: "Listar contas", routeName: 'bill-receive.list'},
                        {id: 1, name: "Criar conta", routeName: 'bill-receive.create'}
                    ]
                    }


                ]
            };
        }
    };
</script>