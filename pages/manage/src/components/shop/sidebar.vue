<template>
    <div id="menus">
        <el-menu @open="handleOpen" @close="handleClose" router :collapse="$store.state.menu.collapse" :default-active="index" v-if="index">
            <template v-for="menu in lists">
                <el-submenu :index="menu.name" v-if="menu.childs && menu.childs.length">
                    <template slot="title">
                        <i :class="'el-icon-' + menu.icon"></i>
                        <span v-text="menu.show_name"></span>
                    </template>
                    <el-menu-item :index="menuChild.name" :route="{path: menuChild.url}" v-for="menuChild in menu.childs" :key="menuChild.name">
                        <i :class="'el-icon-' + menuChild.icon"></i>
                        <span slot="title" v-text="menuChild.show_name"></span>
                    </el-menu-item>
                </el-submenu>
                <el-menu-item :index="menu.name" :route="{path: menu.url}">
                    <i :class="'el-icon-' + menu.icon"></i>
                    <span slot="title" v-text="menu.show_name"></span>
                </el-menu-item>
            </template>
        </el-menu>
    </div>
</template>
<script>
    export default {
        name: 'shop-sidebar',
        data() {
            return {
                lists: [],
                index: 0,
                loading: null
            }
        },
        created() {
            this.loading = this.$loading({
                lock: true,
                text: '加载中...',
            });
        },
        mounted() {
            this.$store.dispatch('initMenu')
            this.getLists()
        },
        methods: {
            getLists() {
                this.$request.get(this.$url.shop.home.menus).then(res => {
                    this.setIndex(res.data.data)
                }).catch(error => {
                    this.loading.close();
                })
            },
            setIndex(data) {
                console.log(data)
                let index = '', that = this
                data.forEach(function (item) {
                    if (that.$route.path == item.url)
                        index = item.name
                })
                this.index = index
                this.lists = data
                this.loading.close();
            },
            handleOpen(key, keyPath) {
                console.log(key, keyPath);
            },
            handleClose(key, keyPath) {
                console.log(key, keyPath);
            }
        }
    }
</script>
<style lang="scss">
    @import "../../assets/scss/main";

    .el-aside {
        background-color: $col-main;
        height: 100%;
        width: auto !important;
        .el-menu {
            height: 100%;
            border-right: 0;
            &:not(.el-menu--collapse) {
                width: 16rem;
            }
        }
    }
</style>
