<template>
    <div id="log">
        <el-tabs v-model="activeName" type="card" @tab-click="tabChange">
            <el-tab-pane label="商户充值" name="top_up"></el-tab-pane>
            <el-tab-pane label="用户购券" name="buy"></el-tab-pane>
            <el-tab-pane label="用户提现" name="payoff"></el-tab-pane>
        </el-tabs>
        <search :search="search" :load="doLoad">
            <div type="text" class="data-info">
                <a :href="downloadUrl" class="el-button el-button--primary is-plain" style="margin-right: 1rem">导出数据</a>
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
            <el-form-item :label="activeName == 'top_up'? '商户名称': '用户名称'" label-width="250">
                <el-input v-model="search.user_name" placeholder=""></el-input>
            </el-form-item>
            <el-form-item :label="activeName == 'top_up'? '商户ID' : '用户ID'" label-width="250">
                <el-input v-model="search.user_id" placeholder=""></el-input>
            </el-form-item>
        </search>
        <div class="break-2"></div>
        <el-card class="box-card">
            <el-table :data="lists" v-loading="loading">
                <el-table-column prop="id" label="编号" width="100"></el-table-column>
                <el-table-column prop="user_name" :label="activeName == 'top_up'? '商户名称' : '用户名称'"></el-table-column>
                <el-table-column prop="user_id" :label="activeName == 'top_up'? '商户ID' : '用户ID'"></el-table-column>
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
                tabs: ['top_up', 'buy', 'payoff'],
                activeName: 'top_up',
                lists: [],
                loading: false,
                pages: {},
                total: 0,
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
            },
            downloadUrl() {
                return this.$url.init.url + this.$url.home.log[this.activeName] + '?download=true&token=' + this.$store.state.token
            }
        },
        mounted() {
            if (this.$route.query.tab)
                this.activeName = this.$route.query.tab
            this.doLoad()
        },
        methods: {
            doLoad() {
                this.search = this.$util.copyObj(this.$route.query)
                this.getLists()
            },
            getLists() {
                this.loading = true
                let url = this.$url.home.log[this.activeName]
                this.$request.get(url, {params: this.search}).then(res => {
                    this.lists = res.data.data
                    this.loading = false
                    this.pages = res.data.meta.pagination
                    this.total = res.data.meta.pagination.total
                }).catch(res => {
                    this.loading = false
                })
            },
            tabChange(tab, event) {
                this.$router.push({query: {tab: this.activeName}})
                this.doLoad()
            }
        }

    }
</script>

<style lang="scss">
    #log {

        .el-form {
            position: relative;
            .data-info {
                padding: 3px 0px;
                position: absolute;
                right: 0;
                z-index: 10;
                a {
                    text-decoration: none;
                }
            }

        }
    }
</style>