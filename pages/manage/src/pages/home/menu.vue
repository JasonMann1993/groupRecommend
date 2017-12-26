<template>
    <div>
        <page-info>
            <div slot="title" v-text="title"></div>
        </page-info>
        <el-card class="box-card">
            <el-table :data="lists"
                      v-loading="loading">
                <el-table-column
                        prop="id"
                        label="编号"
                        width="100">
                </el-table-column>
                <el-table-column
                        prop="icon"
                        label="ICON">
                </el-table-column>
                <el-table-column
                        prop="name"
                        label="名称">
                </el-table-column>
                <el-table-column
                        prop="url"
                        label="Url">
                    <template slot-scope="scope">
                        <el-tag size="small" type="info" v-text="scope.row.url"></el-tag>
                    </template>
                </el-table-column>
                <el-table-column
                        prop="sort"
                        label="排序">
                    <template slot-scope="scope">
                        <el-tag size="small" v-text="scope.row.sort"></el-tag>
                    </template>
                </el-table-column>
                <el-table-column
                        prop="status"
                        label="状态">
                    <template slot-scope="scope">
                        <el-switch
                                v-model.bool="scope.row.status.value">
                        </el-switch>
                    </template>
                </el-table-column>
            </el-table>
        </el-card>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                title: '菜单列表',
                lists: [],
                loading: false,
            }
        },
        mounted() {
            this.getLists()
        },
        methods: {
            getLists() {
                this.loading = true
                this.$request.get(this.$url.home.menu).then(res => {
                    this.lists = res.data.data
                    this.loading = false
                }).catch(res => {
                    this.loading = false
                })
            }
        }

    }
</script>

<style lang="scss" scoped>

</style>