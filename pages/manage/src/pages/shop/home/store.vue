<template>
    <div>
        <page-info>
            <div slot="title" v-text="title"></div>
        </page-info>
        <el-card class="box-card page-info">
            <el-row :gutter="20">
                <el-col :span="24">
                    <label>ID: </label>
                    <span v-text="info.id"></span>
                </el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col :span="24">
                    <label>昵称: </label>
                    <span v-text="info.name"></span>
                </el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col :span="24">
                    <label>营销资金: </label>
                    <span v-text="info.total_balance"></span>
                </el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col :span="24">
                    <label>奖励资金: </label>
                    <span v-text="info.total_award"></span>
                </el-col>
            </el-row>
        </el-card>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                title: '我的店面'
            }
        },
        computed: {
            info() {
                return this.$store.state.user
            }
        },
        mounted() {
        },
        methods: {
            doLoad() {
            },
        }
    }
</script>

<style lang="scss">
</style>