<template>
    <div>
        <page-info>
            <div slot="title" v-text="title"></div>
        </page-info>
        <el-card class="box-card page-info" v-loading="loading">
            <div slot="header" class="clearfix">
                <span>制券奖励</span>
            </div>
            <el-row :gutter="20">
                <el-col :xl="8" :md="12" :xs="24">
                    <label>商家合伙人: </label>
                    <el-input type="number" v-model="info.reward_make_for_partner">
                        <template slot="append">元</template>
                    </el-input>
                </el-col>
                <el-col :xl="8" :md="12" :xs="24">
                    <label>商家推荐人: </label>
                    <el-input type="number" v-model="info.reward_make_for_re_shop">
                        <template slot="append">元</template>
                    </el-input>
                </el-col>
                <el-col :xl="8" :md="12" :xs="24">
                    <label>商家: </label>
                    <el-input type="number" v-model="info.reward_make_for_shop">
                        <template slot="append">元</template>
                    </el-input>
                </el-col>
            </el-row>
        </el-card>
        <div class="break-2"></div>
        <el-card class="box-card page-info" v-loading="loading">
            <div slot="header" class="clearfix">
                <span>核销奖励</span>
            </div>
            <el-row :gutter="20">
                <el-col :xl="8" :md="12" :xs="24">
                    <label>商家合伙人: </label>
                    <el-input type="number" v-model="info.reward_use_for_partner">
                        <template slot="append">元</template>
                    </el-input>
                </el-col>
                <el-col :xl="8" :md="12" :xs="24">
                    <label>商家推荐人: </label>
                    <el-input type="number" v-model="info.reward_use_for_re_shop">
                        <template slot="append">元</template>
                    </el-input>
                </el-col>
                <el-col :xl="8" :md="12" :xs="24">
                    <label>商家: </label>
                    <el-input type="number" v-model="info.reward_use_for_shop">
                        <template slot="append">元</template>
                    </el-input>
                </el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col :xl="8" :md="12" :xs="24">
                    <label>用户: </label>
                    <el-input type="number" v-model="info.reward_use_for_user">
                        <template slot="append">元</template>
                    </el-input>
                </el-col>
                <el-col :xl="8" :md="12" :xs="24">
                    <label>用户推荐人: </label>
                    <el-input type="number" v-model="info.reward_use_for_re_user">
                        <template slot="append">元</template>
                    </el-input>
                </el-col>
            </el-row>
        </el-card>
        <div class="break-2"></div>
        <el-card class="box-card page-info" v-loading="loading">
            <div slot="header" class="clearfix">
                <span>核销扣款</span>
            </div>
            <el-row :gutter="20">
                <el-col :xl="8" :md="12" :xs="24">
                    <label>商家: </label>
                    <el-input type="number" v-model="info.reward_cut_use_for_shop">
                        <template slot="append">元</template>
                    </el-input>
                </el-col>
            </el-row>
        </el-card>
        <div class="break-2"></div>
        <el-card class="box-card page-info" v-loading="loading">
            <div slot="header" class="clearfix">
                <span>制券扣款</span>
            </div>
            <el-row :gutter="20">
                <el-col :xl="8" :md="12" :xs="24">
                    <label>商家: </label>
                    <el-input type="number" v-model="info.cut_make_for_shop">
                        <template slot="append">元</template>
                    </el-input>
                </el-col>
            </el-row>
        </el-card>
        <div class="break-2"></div>
        <div class="center">
            <el-button type="primary" @click="upInfo()" :loading="buttonLoading">修改</el-button>
        </div>
    </div>
</template>
<script>

    export default {
        data() {
            return {
                title: '参数设置',
                info: [],
                loading: false,
                buttonLoading: false,
            }
        },
        mounted() {
            this.doLoad()
        },
        methods: {
            doLoad() {
                this.getInfo()
            },
            getInfo() {
                this.loading = true
                this.$request.get(this.$url.home.argument).then(res => {
                    this.info = res.data.data
                    this.loading = false
                }).catch(error => {
                    this.loading = false
                });
            },
            upInfo() {
                this.buttonLoading = true
                this.$request.put(this.$url.home.argument, this.info).then(res => {
                    this.buttonLoading = false
                    this.doLoad()
                    this.$notify({title: '修改成功', type: 'success'});
                }).catch(error => {
                    this.buttonLoading = false
                });
            }
        }

    }
</script>

<style lang="scss" scoped>
    .page-info {
        label {
            font-weight: inherit;
            font-size: 14px;
            margin-right: 1rem;
        }
        .el-input {
            width: auto;
        }
    }

</style>