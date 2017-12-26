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
                    <el-option v-for="item in status" :key="item.key" :label="item.value" :value="item.key"></el-option>
                </el-select>
            </el-form-item>
        </search>
        <div class="break-2"></div>
        <el-card class="box-card">
            <el-table :data="lists" v-loading="loading">
                <el-table-column prop="id" label="ID" width="100"></el-table-column>
                <el-table-column prop="user_name" label="用户"></el-table-column>
                <el-table-column prop="coupon_name" label="优惠券"></el-table-column>
                <el-table-column prop="order_no" label="订单号"></el-table-column>
                <el-table-column prop="money" label="金额"></el-table-column>
                <el-table-column prop="status" label="支付状态">
                    <template slot-scope="scope">
                        <el-tag :type="statusTag[scope.row.status]" size="small">
                            <span v-text="scope.row.status_text"></span>
                        </el-tag>
                    </template>
                </el-table-column>
                <el-table-column label="操作" width="250">
                    <template slot-scope="scope">
                        <el-button size="mini" @click="doRefund(scope.row.id)" v-if="scope.row.status == 3">确认退款</el-button>
                        <el-tooltip content="详情">
                            <el-button icon="el-icon-info" size="mini" @click="action.indexInfo.id = scope.row.coupon_id,action.indexInfo.show = true"></el-button>
                        </el-tooltip>
                        <button-delete :url="$url.coupon.order + '/' + scope.row.id " @success="doLoad"></button-delete>
                    </template>
                </el-table-column>
            </el-table>
            <div class="table-pages">
                <pages :data="pages"></pages>
            </div>
        </el-card>


        <el-dialog :title="action.indexInfo.title" :visible.sync="action.indexInfo.show" width="80%">
            <index-info :id="action.indexInfo.id" @close="action.indexInfo.show = false" @success="doLoad"></index-info>
        </el-dialog>
    </div>
</template>
<script>
    import IndexInfo from '../index/info.vue'

    export default {
        components: {
            'index-info': IndexInfo,
        },
        data() {
            return {
                action: {
                    indexInfo: {
                        title: '详情',
                        show: false
                    }
                },
                statusTag: {
                    1: '', 2: 'success', 3: 'warning', 4: 'info', 5: 'danger'
                },
                search: {},
                status: [
                    {key: 1, value: '未支付'},
                    {key: 2, value: '已支付'},
                    {key: 3, value: '待退款'},
                    {key: 4, value: '已完成'},
                    {key: 5, value: '支付失败'},
                    {key: 6, value: '已退款'},
                ],
                title: '订单列表',
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
                this.$request.get(this.$url.coupon.order, {params: this.search}).then(res => {
                    this.lists = res.data.data
                    this.pages = res.data.meta.pagination
                    this.loading = false
                }).catch(res => {
                    this.loading = false
                })
            },
            doRefund(id) {
                this.$confirm('确认退款, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.$request.post(this.$url.coupon.order + '/' + id + '/refund').then(res => {
                        this.$message({
                            type: 'success',
                            message: '退款成功!'
                        });
                        this.doLoad()
                    }).catch(res => {
                        let message = '退款失败';
                        if (res.response.status == 404)
                            message = '没有需要退款的订单'
                        else if (res.response.status == 501)
                            message = res.response.data.message
                        this.$message({
                            type: 'error',
                            message: message
                        });
                    })
                })
            }
        }

    }
</script>

<style lang="scss" scoped>

</style>