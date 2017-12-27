<template>
    <div>
        <el-form ref="form" :rules="rules" :model="post" label-width="80px" v-loading="pageLoading">
            <el-form-item label="名称" prop="name">
                <el-input v-model="post.name"></el-input>
            </el-form-item>
            <el-form-item label="内容" prop="content">
                <el-input type="textarea" v-model="post.content"></el-input>
            </el-form-item>
            <el-form-item label="图片" prop="picture">
                <upload @success="uploadSuccess" @remove="uploadRemove"></upload>
            </el-form-item>
            <el-form-item label="排序" prop="order">
                <el-input type="number" v-model="post.order"></el-input>
            </el-form-item>
            <el-form-item label="是否显示" prop="show">
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
                post: {
                    carousel_time: 2,
                    show: true
                },
                rules: {
                    name: [
                        {required: true, message: '请输入名称', trigger: 'blur'},
                    ],
                },
                buttonLoading: false,
                pageLoading: false,
            }
        },
        methods: {
            onSubmit() {
                this.doValidate(() => {
                    this.buttonLoading = true
                    this.$request.post(this.$url.home.banner, this.post).then(res => {
                        this.buttonLoading = false
                        this.$notify({title: '添加成功', type: 'success'});

                        this.doResetForm()

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
            },
            uploadSuccess(res) {
                this.post.picture = res.file
            },
            uploadRemove(res) {
                this.post.picture = null
            }
        }
    }
</script>