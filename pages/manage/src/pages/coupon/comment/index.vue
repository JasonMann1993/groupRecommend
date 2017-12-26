<template>
    <div>
        <page-info>
            <div slot="title" v-text="title"></div>
        </page-info>
        <search :search="search" :load="doLoad">
            <el-form-item label="关键字">
                <el-input v-model="search.keyword" placeholder="内容/用户昵称"></el-input>
            </el-form-item>
            <el-form-item label="状态">
                <el-select v-model="search.status" placeholder="请选择" clearable>
                    <el-option v-for="item in status" :key="item.key" :label="item.value" :value="item.key"> </el-option>
                </el-select>
            </el-form-item>
        </search>
        <div class="break-2"></div>
        <el-card class="box-card">
            <el-table :data="lists" v-loading="loading">
                <el-table-column prop="id" label="ID" width="100"></el-table-column>
                <el-table-column prop="user_name" label="用户"></el-table-column>
                <el-table-column prop="coupon_name" label="优惠券"></el-table-column>
                <el-table-column prop="content" label="内容">
                    <template slot-scope="scope">
                        <span v-text="scope.row.content.substring(0,15)"></span>
                    </template>
                </el-table-column>
                <el-table-column
                        prop="status"
                        label="状态">
                    <template slot-scope="scope">
                        <el-tag :type="statusTag[scope.row.status]" size="small">
                            <span v-text="scope.row.status_text"></span>
                        </el-tag>
                    </template>
                </el-table-column>
                <el-table-column prop="created_at" label="创建时间"></el-table-column>
                <el-table-column label="操作">
                    <template slot-scope="scope">
                        <el-tooltip content="编辑">
                            <el-button icon="el-icon-info" size="mini" @click="action.info.id = scope.row.id,action.info.show = true"></el-button>
                        </el-tooltip>
                        <button-delete :url="$url.coupon.comment + '/' + scope.row.id " @success="doLoad"></button-delete>
                    </template>
                </el-table-column>
            </el-table>
            <div class="table-pages">
                <pages :data="pages"></pages>
            </div>
        </el-card>

        <el-dialog :title="action.info.title" :visible.sync="action.info.show">
            <info :id="action.info.id" @close="action.info.show = false" @success="doLoad"></info>
        </el-dialog>
    </div>
</template>
<script>
    import Info from './info.vue'

    export default {
        components: {
            'info': Info,
        },
        data() {
            return {
                action: {
                    info: {
                        title: '详情',
                        show: false
                    }
                },
                statusTag: {
                    1: '', 2: 'success', 3: 'info'
                },
                search: {},
                status: [
                    {key: 1, value: '待审核'},
                    {key: 2, value: '已审核'},
                    {key: 3, value: '垃圾信息'},
                ],
                title: '评论列表',
                lists: [],
                loading: false,
                pages: {}
            }
        },
        watch: {
            $route: 'doLoad',
        },
        mounted() {
            this.doLoad()
        },
        methods: {
            doLoad() {
                this.search = this.$util.copyObj(this.$route.query)
                this.getLists()
            },
            getLists() {
                this.loading = true
                this.$request.get(this.$url.coupon.comment, {params: this.search}).then(res => {
                    this.lists = res.data.data
                    this.pages = res.data.meta.pagination
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