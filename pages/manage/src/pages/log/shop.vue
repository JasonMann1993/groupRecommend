<template>
    <div>
        <search :search="search" :load="doLoad">
            <div style="float: right; padding: 3px 0" type="text">
                总金额: <span style="color: red" v-text="totalMoney"></span> 元
                <span style="margin-right: 1rem"></span>
                条目数: <span v-text="total"></span> 条
            </div>
            <el-row>
                <el-form-item label="时间" label-width="250">
                    <el-date-picker v-model="search.time" value-format="yyyy-MM-dd HH:mm:ss" type="datetimerange" range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期">
                    </el-date-picker>
                </el-form-item>
            </el-row>
            <el-form-item label="商家名称" label-width="250">
                <el-input v-model="search.user_name" placeholder=""></el-input>
            </el-form-item>
            <el-form-item label="类型">
                <el-select v-model="search.type" placeholder="请选择" clearable>
                    <el-option v-for="(item,key) in types" :key="key" :label="item" :value="key"></el-option>
                </el-select>
            </el-form-item>
        </search>
        <div class="break-2"></div>
        <el-card class="box-card">
            <el-table :data="lists" v-loading="loading">
                <el-table-column prop="id" label="编号" width="100"></el-table-column>
                <el-table-column prop="user_name" label="商户名称"></el-table-column>
                <el-table-column prop="coupon_name" label="优惠券名称"></el-table-column>
                <el-table-column prop="verify" label="类型">
                    <template slot-scope="scope">
                        <el-tag :type="typeTag[scope.row.type]" size="small">
                            <span v-text="types[scope.row.type]"></span>
                        </el-tag>
                    </template>
                </el-table-column>
                <el-table-column prop="money" label="金额"></el-table-column>
                <el-table-column prop="created_at" label="操作时间"></el-table-column>
            </el-table>
            <div class="table-pages">
                <pages :data="pages"></pages>
            </div>
        </el-card>

    </div>
</template>
<script>
    export default {
        data() {
            return {
                search: {},
                lists: [],
                loading: false,
                pages: {},
                total: 0,
                types: {
                    1: '制券', 2: '核销', 3: '提现',
                },
                typeTag: {
                    1: '', 2: 'success', 3: 'info',
                }
            }
        },
        watch: {
            $route: 'doLoad',
        },
        computed: {
            totalMoney() {
                if (this.lists.length)
                    return this.lists[0].total_money
                return 0
            }
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
                this.$request.get(this.$url.partner.log, {params: this.search}).then(res => {
                    this.lists = res.data.data
                    this.loading = false
                    this.pages = res.data.meta.pagination
                    this.total = res.data.meta.pagination.total
                }).catch(res => {
                    this.loading = false
                })
            },
        }

    }
</script>

<style lang="scss" scoped>

</style>