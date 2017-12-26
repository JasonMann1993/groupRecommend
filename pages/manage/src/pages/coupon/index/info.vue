<template>
    <div>
        <el-card class="box-card page-info" v-loading="pageLoading">
            <div slot="header" class="clearfix">
                <span>优惠券信息</span>
            </div>
            <el-row :gutter="20">
                <el-col :span="8">
                    <label>昵称: </label>
                    <span v-text="info.user_name"></span>
                </el-col>
                <el-col :span="8">
                    <label>发放数量: </label>
                    <span v-text="info.total"></span>
                </el-col>
                <el-col :span="8">
                    <label>使用范围: </label>
                    <span v-text="info.limit"></span>
                </el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col :span="8">
                    <label>店名: </label>
                    <span v-text="info.name"></span>
                </el-col>
                <el-col :span="8">
                    <label>已领数量: </label>
                    <span v-text="info.got_num"></span>
                </el-col>
                <el-col :span="8">
                    <label>关键字: </label>
                    <span>
                        <el-tag v-for="keyword in info.keywords" :key="keyword" style="margin-right: .5rem">
                          {{ keyword }}
                        </el-tag>
                    </span>
                </el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col :span="8">
                    <label>行业分类: </label>
                    <span v-text="info.type_text"></span>
                </el-col>
                <el-col :span="8">
                    <label>优惠开始: </label>
                    <span v-text="info.start"></span>
                </el-col>
                <el-col :span="8">
                    <label>地址: </label>
                    <span v-text="info.address"></span>
                </el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col :span="8">
                    <label>优惠金额: </label>
                    <span v-text="info.sale_value_text"></span>
                </el-col>
                <el-col :span="8">
                    <label>优惠结束: </label>
                    <span v-text="info.end"></span>
                </el-col>
                <el-col :span="8">
                    <label>电话: </label>
                    <span v-text="info.phone"></span>
                </el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col :span="8">
                    <label>优惠类型: </label>
                    <span v-text="info.sale_type_text"></span>
                </el-col>
                <el-col :span="8">
                    <label>添加时间: </label>
                    <span v-text="info.created_at"></span>
                </el-col>
                <el-col :span="8">
                    <label>审核: </label>
                    <span>
                        <el-button plain v-text="info.verify_text" size="small" :type="verifyTag[info.verify]" @click="checkPage = true"></el-button>
                    </span>
                    <el-dialog width="30%" title="审核" :visible.sync="checkPage" append-to-body>
                        <el-input type="textarea" :rows="3" :placeholder="info.last_check_msg || '备注'" v-model="post.remark"></el-input>
                        <div slot="footer" class="dialog-footer center">
                            <el-button type="danger" @click="upVerify(3)">驳回</el-button>
                            <el-button type="success" @click="upVerify(2)">通过</el-button>
                        </div>
                    </el-dialog>
                </el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col :span="8">
                    <label>购券价格: </label>
                    <span v-text="info.price"></span>
                </el-col>
                <el-col :span="8">
                    <label>审核时间: </label>
                    <span v-text="info.verified_at"></span>
                </el-col>
                <el-col :span="8">
                    <label>
                        <el-button plain size="" icon="el-icon-edit" @click="action.edit.id = info.id,action.edit.show = true">修改优惠券</el-button>
                    </label>
                </el-col>
            </el-row>
        </el-card>
        <div class="break-2"></div>
        <el-card class="box-card page-info" v-loading="pageLoading" v-if="info.stats">
            <div class="stats">
                <div class="stat views">
                    <div class="title">浏览量 ( <span v-text="info.stat_count.view"></span> )</div>
                    <div class="content">
                        <ul>
                            <li v-for="item in info.stats.view">
                                <img :src="item.user_avatar" alt="" class="user-avatar">
                                <span v-text="item.user_name"></span>
                                <span class="time" v-text="item.created_at"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="stat gets">
                    <div class="title">领取量 ( <span v-text="info.stat_count.get"></span> )</div>
                    <div class="content">
                        <ul>
                            <li v-for="item in info.stats.get">
                                <img :src="item.user_avatar" alt="" class="user-avatar">
                                <span v-text="item.user_name"></span>
                                <span class="time" v-text="item.created_at"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="stat uses">
                    <div class="title">使用量 ( <span v-text="info.stat_count.use"></span> )</div>
                    <div class="content">
                        <ul>
                            <li v-for="item in info.stats.use">
                                <img :src="item.user_avatar" alt="" class="user-avatar">
                                <span v-text="item.user_name"></span>
                                <span class="time" v-text="item.created_at"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </el-card>

        <el-dialog :title="action.edit.title" :visible.sync="action.edit.show" append-to-body>
            <edit :id="action.edit.id" @close="action.edit.show = false" @success="doLoad(), $emit('success')"></edit>
        </el-dialog>
    </div>
</template>
<script>
    import Edit from './edit.vue'

    export default {
        components: {
            'edit': Edit,
        },
        props: {
            id: Number
        },
        data() {
            return {
                action: {
                    edit: {
                        title: '编辑',
                        show: false
                    }
                },
                verifyTag: {
                    1: '', 2: 'success', 3: 'danger', 4: 'info'
                },
                info: {},
                post: {},
                pageLoading: false,
                checkPage: false
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
                this.$request.get(this.$url.coupon.index + '/' + this.id).then(res => {
                    this.info = res.data.data
                    this.pageLoading = false
                }).catch(error => {
                    this.pageLoading = false
                });
            },
            upVerify(status) {
                this.post.verify = status
                this.$request.patch(this.$url.coupon.index + '/' + this.id + '/verify', this.post).then(res => {
                    this.getInfo();
                    this.checkPage = false
                    this.post = {}
                    this.$notify({title: '操作成功', type: 'success'});
                    this.$emit('success')
                }).catch(error => {
                });
            },
        }
    }
</script>

<style lang="scss" scoped>
    .stats {
        .stat {
            width: 33%;
            float: left;
            padding: 1rem 0;
            ul{
                list-style: none;
                line-height: 4;
                padding: 0;
                display: grid;
                li{
                    margin: .5rem 0;
                    padding-right: 1rem;
                    .time{
                        float: right !important;
                    }
                    & *{
                        float: left;
                        margin-right: 1rem;
                    }
                }
            }
        }
    }
</style>