<template>
    <div id="login">
        <el-row>
            <el-col :xs="20" :sm="16" :md="14" :lg="12" :xl="10" class="login-form">
                <h1>登录到后台</h1>
                <el-form ref="form" :model="post" :rules="rules" label-width="80px">
                    <el-form-item label="手机号" prop="name">
                        <el-input v-model="post.name"></el-input>
                    </el-form-item>
                    <el-form-item label="密码" prop="password">
                        <el-input v-model="post.password" type="password"></el-input>
                    </el-form-item>
                    <div class="login-button">
                        <el-button plain @click="doLogin" :loading="loginButtonLoading">登录
                        </el-button>
                    </div>
                </el-form>
            </el-col>
        </el-row>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                post: {
                    name: '',
                    password: '',
                },
                loginButtonLoading: false,
                rules: {
                    name: [
                        {required: true, message: '请输入手机号', trigger: 'blur'},
                    ],
                    password: [
                        {required: true, message: '请输入密码', trigger: 'blur'},
                    ],
                }
            }
        },
        methods: {
            doLogin() {
                this.$refs['form'].validate((valid) => {
                    if (valid) {
                        this.loginButtonLoading = true
                        this.$request.post(this.$url.user.login, this.post).then(res => {
                            this.$store.commit('login', {data: res.data, type: ''})
                            this.$router.push('/');
                        }).catch(error => {
                            this.loginButtonLoading = false
                        });
                    }
                    return false;
                });
            }
        }
    }
</script>

<style lang="scss">
    @import "../../assets/scss/base";

    #login {
        h1 {
            text-align: center;
            margin-bottom: 3rem;
            font-weight: 300;
        }
        height: 100%;
        .el-row {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            .login-form {
                background: $col-main;
                padding: 2rem 3rem 4rem;
            }
            .el-form-item {
                margin-bottom: 2rem;
            }
            .login-button {
                text-align: center;
                button {
                    margin-top: 1rem;
                    padding: .8rem 2rem;
                }
            }
        }
    }
</style>