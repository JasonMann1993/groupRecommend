<template>
    <div>
        <el-form ref="form" :rules="rules" :model="post" label-width="80px" v-loading="pageLoading">
            <el-form-item label="昵称" prop="name">
                <el-input v-model="post.name"></el-input>
            </el-form-item>
            <el-form-item label="用户身份" prop="phone">
                <el-input v-model="post.phone"></el-input>
            </el-form-item>
            <el-form-item label="用户地址" prop="phone">
                <el-input v-model="post.phone"></el-input>
            </el-form-item>
            <el-form-item label="所在群聊" prop="phone">
                <el-input v-model="post.phone"></el-input>
            </el-form-item>
            <el-form-item label="活跃星级" prop="phone">
                <el-input v-model="post.phone"></el-input>
            </el-form-item>
            <el-form-item label="排序" prop="order">
                <el-input type="number" v-model="post.order"></el-input>
            </el-form-item>
            <el-form-item label="拉黑" prop="show">
                <el-switch v-model="post.show"></el-switch>
            </el-form-item>
        </el-form>
        <div slot="footer" class="center">
            <el-button type="primary" @click="onSubmit" :loading="buttonLoading">确定</el-button>
        </div>
    </div>
</template>
<script>

    export default {
        props: {
            id: Number
        },
        data() {
            return {
                post: {},
                rules: {
                    name: [
                        {required: true, message: '请输入用户名', trigger: 'blur'},
                        {min: 2, max: 15, message: '长度在 2 到 15 个字符', trigger: 'blur'}
                    ],
                    phone: [
                        {required: true, message: '请输入手机号', trigger: 'blur'},
                        {pattern: /^1[34578][0-9]{9}$/, message: '请输入正确的手机号', trigger: 'blur'}
                    ],
                    password: [
                        {required: false, message: '请输入密码', trigger: 'blur'},
                        {min: 6, max: 20, message: '长度在 6 到 20 个字符', trigger: 'blur'}
                    ],
                },
                buttonLoading: false,
                pageLoading: false,
            }
        },
        watch: {
            id() {
                this.doLoad()
            }
        },
        mounted() {
            this.doLoad()
        },
        methods: {
            async doLoad() {
                await this.doResetForm()
                this.getInfo()
            },
            getInfo() {
                this.pageLoading = true
                this.$request.get(this.$url.user.partner + '/' + this.id).then(res => {
                    this.pageLoading = false
                    this.post = res.data.data
                }).catch(error => {
                    this.pageLoading = false
                });
            },
            onSubmit() {
                this.doValidate(() => {
                    this.buttonLoading = true
                    this.$request.put(this.$url.user.partner + '/' + this.id, this.post).then(res => {
                        this.buttonLoading = false
                        this.$notify({title: '编辑成功', type: 'success'});

                        this.$emit('success')
                        this.$emit('close')
                    }).catch(error => {
                        this.buttonLoading = false
                    });
                })
            },
            doValidate(callback) {
                this.$refs['form'].validate((valid) => {
                    if (valid)
                        return callback()
                    return false;
                });
            },
            async doResetForm() {
                await this.$refs['form'].resetFields();
            }
        }
    }
</script>