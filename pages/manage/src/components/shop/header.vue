<template>
    <div class="nav-bar">
        <div class="title">
            <h2>后台管理系统</h2>
        </div>
        <div class="switch-menu">
            <i class="el-icon-menu" @click="$store.dispatch('changeMenuType')"></i>
        </div>
        <div class="users">
            <el-dropdown @command="handleCommand">
                <div>
                    <img :src="info.avatar" alt="" width="40" class="avatar" v-if="info.avatar">
                    <span class="user-name" v-text="info.name"></span>
                </div>

                <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item command="logout">退出</el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'shop-header',
        data() {
            return {
                info: {}
            }
        },
        created() {
            this.getUserInfo()
        },
        methods: {
            getUserInfo() {
                this.$request.get(this.$url.shop.user.info).then(res => {
                    this.info = res.data.data
                    this.$store.dispatch('upUser', this.info)
                })
            },
            handleCommand(command) {
                if (command == 'logout')
                    this.logout()
            },
            logout() {
                this.$message.success('退出成功，请重新登录')
                this.$store.commit('logout');
            }
        }
    }
</script>
<style lang="scss">
    @import "../../assets/scss/main";

    .el-header {
        background-color: $col-main;
        .title {
            width: 16rem;
            text-align: center;
            line-height: 60px;
            h2 {
                margin: 0;
                font-size: 1.2rem;
            }
        }
        .nav-bar {
            div {
                float: left;
            }
            .switch-menu {
                line-height: 60px;
                i {
                    text-align: center;
                    padding: 1rem;
                    cursor: pointer;
                    &:hover {
                        color: $col-light;
                    }
                }
            }
            .users {
                float: right;
                cursor: pointer;
                .avatar {
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    margin-top: 10px;
                }
                .user-name {
                    line-height: 60px;
                    float: right;
                    margin-left: .5rem;
                    margin-right: 2rem;
                }
            }
        }
    }
</style>