<template>
    <div>
        <el-card class="box-card page-info" v-loading="pageLoading">
            <el-row :gutter="20">
                <el-col :span="24">
                    <label>用户: </label>
                    <span v-text="info.user_name"></span>
                </el-col>
                <el-col :span="24">
                    <label>内容: </label>
                    <span v-text="info.content"></span>
                </el-col>
                <el-col :span="24">
                    <label>时间: </label>
                    <span v-text="info.created_at"></span>
                </el-col>
                <el-col :span="24">
                    <label>状态: </label>
                    <el-tag :type="statusTag[info.status]">
                        <span v-text="info.status_text"></span>
                    </el-tag>
                </el-col>
            </el-row>
        </el-card>
        <div class="break-2"></div>
        <div slot="footer" class="center">
            <el-button type="success" icon="el-icon-check" @click="post.status = 2,upStatus()">通过</el-button>
            <el-button type="danger" icon="el-icon-close" @click="post.status = 3,upStatus()">驳回</el-button>
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
                statusTag: {
                    1: '', 2: 'success', 3: 'info'
                },
                info: {},
                post: {},
                pageLoading: false,
            }
        },
        watch: {
            id() {
                this.info = {}
                this.doLoad()
            }
        },
        mounted() {
            this.getInfo()
        },
        methods: {
            doLoad() {
                this.getInfo()
            },
            getInfo() {
                this.pageLoading = true
                this.$request.get(this.$url.coupon.comment + '/' + this.id).then(res => {
                    this.pageLoading = false
                    this.info = res.data.data
                }).catch(error => {
                    this.pageLoading = false
                });
            },
            upStatus() {
                this.$request.patch(this.$url.coupon.comment + '/' + this.id + '/status', this.post).then(res => {
                    this.getInfo();
                    this.$notify({title: '操作成功', type: 'success'});
                    this.$emit('success')
                    this.$emit('close')
                }).catch(error => {
                });
            },
        }
    }
</script>