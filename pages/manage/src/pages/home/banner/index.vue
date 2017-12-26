<template>
    <div>
        <page-info>
            <div slot="title" v-text="title"></div>
            <el-button type="primary" size="small" icon="el-icon-plus" plain @click="action.add.show = true">
                添加 Banner
            </el-button>
        </page-info>
        <el-card class="box-card">
            <el-table :data="lists"
                      v-loading="loading">
                <el-table-column prop="id" label="ID" width="100"></el-table-column>
                <el-table-column prop="name" label="名称"></el-table-column>
                <el-table-column prop="picture" label="图片">
                    <template slot-scope="scope">
                        <img :src="scope.row.picture" alt="" class="table-image" width="50">
                    </template>
                </el-table-column>
                <el-table-column prop="created_at" label="创建时间"></el-table-column>
                <el-table-column
                        prop="status"
                        label="状态">
                    <template slot-scope="scope">
                        <el-switch v-model.bool="scope.row.show" @change="upShow(scope.row.show, scope.row.id)"></el-switch>
                    </template>
                </el-table-column>
                <el-table-column label="操作">
                    <template slot-scope="scope">
                        <el-tooltip content="编辑">
                            <el-button icon="el-icon-edit" size="mini" @click="action.edit.id = scope.row.id,action.edit.show = true"></el-button>
                        </el-tooltip>
                        <button-delete :url="$url.home.banner + '/' + scope.row.id " @success="doLoad"></button-delete>
                    </template>
                </el-table-column>
            </el-table>
            <div class="table-pages">
                <pages :data="pages"></pages>
            </div>
        </el-card>

        <el-dialog :title="action.add.title" :visible.sync="action.add.show">
            <add @close="action.add.show = false" @success="doLoad"></add>
        </el-dialog>
        <el-dialog :title="action.edit.title" :visible.sync="action.edit.show">
            <edit :id="action.edit.id" @close="action.edit.show = false" @success="doLoad"></edit>
        </el-dialog>
    </div>
</template>
<script>
    import Edit from './edit.vue'
    import Add from './add.vue'

    export default {
        components: {
            'add': Add,
            'edit': Edit,
        },
        data() {
            return {
                action: {
                    add: {
                        title: '添加 Banner',
                        show: false
                    },
                    edit: {
                        title: '编辑',
                        show: false
                    }
                },
                title: 'Banner 列表',
                lists: [],
                loading: false,
                pages: {}
            }
        },
        mounted() {
            this.doLoad()
        },
        watch: {
            $route: 'doLoad',
        },
        methods: {
            doLoad() {
                this.search = this.$util.copyObj(this.$route.query)
                this.getLists()
            },
            getLists() {
                this.loading = true
                this.$request.get(this.$url.home.banner, {params: this.search}).then(res => {
                    this.lists = res.data.data
                    this.loading = false
                }).catch(res => {
                    this.loading = false
                })
            },
            upShow(val, id) {
                this.$request.patch(this.$url.home.banner + '/' + id + '/show', {show: val}).then(res => {
                })
            }
        }

    }
</script>

<style lang="scss" scoped>

</style>