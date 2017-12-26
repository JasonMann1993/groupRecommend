<template>
    <div>
        <page-info>
            <div slot="title" v-text="title"></div>
        </page-info>
        <search :search="search" :load="doLoad">
            <el-form-item label="关键字">
                <el-input v-model="search.keyword" placeholder="名称/关键字"></el-input>
            </el-form-item>
            <el-form-item label="分类">
                <el-select v-model="search.type" placeholder="请选择" clearable>
                    <el-option v-for="item in types" :key="item.key" :label="item.value" :value="item.key"></el-option>
                </el-select>
            </el-form-item>
        </search>
        <div class="break-2"></div>
        <el-card class="box-card">
            <el-table :data="lists" v-loading="loading">
                <el-table-column prop="id" label="ID" width="100"></el-table-column>
                <el-table-column prop="user_name" label="用户"></el-table-column>
                <el-table-column prop="coupon_name" label="名称"></el-table-column>
                <el-table-column prop="img" label="图片">
                    <template slot-scope="scope">
                        <img :src="scope.row.img" alt="" class="table-image" width="50">
                    </template>
                </el-table-column>
                <el-table-column prop="sale_value" label="优惠度"></el-table-column>
                <el-table-column prop="verify" label="审核状态">
                    <template slot-scope="scope">
                        <el-tag :type="verifyTag[scope.row.verify]" size="small">
                            <span v-text="scope.row.verify_text"></span>
                        </el-tag>
                    </template>
                </el-table-column>
                <el-table-column prop="status" label="显示状态">
                    <template slot-scope="scope">
                        <el-switch v-model.bool="scope.row.status" @change="upStatus(scope.row.status, scope.row.id)"></el-switch>
                    </template>
                </el-table-column>
                <el-table-column label="操作">
                    <template slot-scope="scope">
                        <el-tooltip content="编辑">
                            <el-button icon="el-icon-info" size="mini" @click="action.info.id = scope.row.id,action.info.show = true"></el-button>
                        </el-tooltip>
                        <button-delete :url="$url.coupon.index + '/' + scope.row.id " @success="doLoad"></button-delete>
                    </template>
                </el-table-column>
            </el-table>
            <div class="table-pages">
                <pages :data="pages"></pages>
            </div>
        </el-card>

        <el-dialog :title="action.info.title" :visible.sync="action.info.show" width="80%">
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
                    },
                },
                verifyTag: {
                    1: '', 2: 'success', 3: 'danger', 4: 'info'
                },
                search: {},
                types: [
                    {key: 1, value: '推荐'},
                    {key: 2, value: '美食'},
                    {key: 3, value: '娱乐'},
                    {key: 4, value: '酒店'},
                    {key: 5, value: '服饰'},
                    {key: 6, value: '教育'},
                    {key: 7, value: '丽人'},
                    {key: 8, value: '其他'},
                ],

                title: '优惠券列表',
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
                this.$request.get(this.$url.coupon.index, {params: this.search}).then(res => {
                    this.lists = res.data.data
                    this.pages = res.data.meta.pagination
                    this.loading = false
                }).catch(res => {
                    this.loading = false
                })
            },
            upStatus(val, id) {
                this.$request.patch(this.$url.coupon.index + '/' + id + '/status', {status: val}).then(res => {
                })
            }
        }

    }
</script>

<style lang="scss" scoped>

</style>