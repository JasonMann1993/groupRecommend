<template>
    <el-popover placement="top" v-model="status">
        <template slot="reference">
            <el-tooltip content="删除">
                <el-button icon="el-icon-delete" size="mini" type="danger">
                </el-button>
            </el-tooltip>
        </template>
        <p>确定要删除吗？</p>
        <div style="text-align: right; margin: 0">
            <el-button size="mini" type="text" @click="status = false">取消</el-button>
            <el-button type="primary" :loading="buttonLoading" size="mini" @click="ensure">确定</el-button>
        </div>
    </el-popover>
</template>
<script>
    export default {
        props: {
            url: [String]
        },
        data() {
            return {
                status: false,
                buttonLoading: false,
            }
        },
        methods: {
            ensure() {
                this.buttonLoading = true
                this.$request.delete(this.url).then(res => {
                    this.status = false
                    this.buttonLoading = false
                    this.$notify({title: '删除成功', type: 'success'});
                    this.$emit('success')
                }).catch(res => {
                    this.buttonLoading = false
                })
            }
        }
    }
</script>
