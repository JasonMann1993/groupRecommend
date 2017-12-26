<template>
    <div>
        <el-form ref="form" :rules="rules" :model="post" label-width="100px" v-loading="pageLoading">
            <el-form-item label="输入店名" prop="name">
                <el-input v-model="post.name" placeholder="请输入店名"></el-input>
            </el-form-item>
            <el-form-item label="选择行业" prop="type">
                <el-select v-model="post.type" placeholder="请选择">
                    <el-option v-for="item in types" :key="item.key" :label="item.value" :value="item.key"></el-option>
                </el-select>
            </el-form-item>
            <el-row :gutter="20">
                <el-col :span="12">
                    <el-form-item label="优惠类型" prop="sale_type">
                        <el-radio-group v-model="post.sale_type">
                            <el-radio :label="parseInt(key)" v-for="item,key in prefer" :key="key">
                                {{ item.complete }}
                            </el-radio>
                        </el-radio-group>
                    </el-form-item>
                </el-col>
                <el-col :span="12">
                    <el-form-item label="优惠金额" prop="sale_value">
                        <el-input type="number" v-model="post.sale_value" :disabled="!post.sale_type">
                            <template slot="append">{{ preferText }}</template>
                        </el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-form-item label="发放数量" prop="total">
                <el-input type="number" v-model="post.total" placeholder="优惠券ID"></el-input>
            </el-form-item>
            <el-form-item label="最大领取数量" prop="times">
                <el-input type="number" v-model="post.times"></el-input>
            </el-form-item>
            <el-form-item label="使用范围" prop="limit">
                <el-input type="textarea" :rows="3" v-model="post.limit"></el-input>
            </el-form-item>
            <el-form-item label="门店电话" prop="phone">
                <el-input v-model="post.phone"></el-input>
            </el-form-item>
            <el-row :gutter="20">
                <el-col :span="12">
                    <el-form-item label="开始时间" prop="start">
                        <el-date-picker v-model="post.start" type="date" placeholder="选择日期" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd">
                        </el-date-picker>
                    </el-form-item>
                </el-col>
                <el-col :span="12">
                    <el-form-item label="结束时间" prop="end">
                        <el-date-picker v-model="post.end" type="date" placeholder="选择日期" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd" :picker-options="{ minTime: post.start }">
                        </el-date-picker>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-form-item label="周几可用" prop="week">
                <el-radio-group v-model="post.week" size="small">
                    <el-radio :label="parseInt(key)" v-for="item,key in weeks" :key="key" border>
                        {{ item }}
                    </el-radio>
                </el-radio-group>
            </el-form-item>
            <el-form-item label="可用时间段" prop="time">
                <el-radio-group v-model="post.time" size="small">
                    <el-radio :label="parseInt(key)" v-for="item,key in times" :key="key" border>
                        {{ item }}
                    </el-radio>
                </el-radio-group>
            </el-form-item>
            <el-form-item label="卡券售价" prop="price">
                <el-input type="number" v-model="post.price">
                    <template slot="append">元</template>
                </el-input>
            </el-form-item>
            <el-form-item label="关键词" prop="keyword">
                <el-input v-model="post.keyword" placeholder="使用 , 分开"></el-input>
            </el-form-item>
            <el-form-item label="门店地址" prop="address" v-if="mapKey && mapUrl">
                <el-input v-model="post.address" disabled=""></el-input>
                <iframe allow="geolocation" id="mapPage" width="100%" height="600" frameborder="0" :src="mapUrl">
                </iframe>
            </el-form-item>
            <el-form-item label="门店LOGO" prop="img">
                <upload @success="uploadSuccess" @remove="uploadRemove" :files="post.img_url"></upload>
            </el-form-item>
        </el-form>
        <div slot="footer" class="center">
            <el-button type="primary" @click="onSubmit" :loading="buttonLoading">确定</el-button>
        </div>
    </div>
</template>
<script>

    export default {
        props: {
            id: Number
        },
        computed: {
            preferText() {
                return this.prefer[this.post.sale_type] ? this.prefer[this.post.sale_type].simple : ''
            },
            mapUrl() {
                let url = "https://apis.map.qq.com/tools/locpicker?search=1&type=1&key=" + this.mapKey + "&referer=myapp"
                if (this.address.longitude && this.address.latitude)
                    url += '&coord=' + this.address.longitude + ',' + this.address.latitude
                else
                    return null
                return url
            }
        },
        data() {
            return {
                post: {},
                rules: {
                },
                types: [
//                    {key: 1, value: '推荐'},
                    {key: 2, value: '美食'},
                    {key: 3, value: '娱乐'},
                    {key: 4, value: '酒店'},
                    {key: 5, value: '服饰'},
                    {key: 6, value: '教育'},
                    {key: 7, value: '丽人'},
                    {key: 8, value: '其他'},
                ],
                prefer: {
                    1: {simple: '元', complete: '减免'},
                    2: {simple: '折', complete: '折扣'}
                },
                weeks: {
                    0: '周一到周日',
                    1: '周一到周五',
                    2: '周六到周日',
                },
                times: {
                    1: '上午',
                    2: '下午',
                    3: '晚上',
                    4: '全天',
                },
                buttonLoading: false,
                pageLoading: false,
                mapKey: null,
                address: {}
            }
        },
        watch: {
            id() {
                this.doLoad()
            }
        },
        mounted() {
            this.doLoad()
            this.getMapKey()
        },
        methods: {
            async doLoad() {
                await this.doResetForm()
                this.getInfo()
                // 地图
                this.getMap()
            },
            getInfo() {
                this.pageLoading = true
                this.$request.get(this.$url.coupon.index + '/' + this.id).then(res => {
                    this.pageLoading = false
                    this.post = res.data.data
                    this.address = {
                        latitude: res.data.data.latitude,
                        longitude: res.data.data.longitude
                    }
                }).catch(error => {
                    this.pageLoading = false
                });
            },
            onSubmit() {
                this.doValidate(() => {
                    this.buttonLoading = true
                    this.$request.put(this.$url.coupon.index + '/' + this.id, this.post).then(res => {
                        this.buttonLoading = false
                        this.$notify({title: '编辑成功', type: 'success'});
                        this.$emit('success')
                        this.$emit('close')
                    }).catch(error => {
                        this.buttonLoading = false
                    });
                })
            },
            doValidate(callback) {
                this.$refs['form'].validate((valid) => {
                    if (valid)
                        return callback()
                    return false;
                });
            },
            getMapKey() {
                this.$request.get(this.$url.home.map_key).then(res => {
                    this.mapKey = res.data.data
                })
            },
            getMap() {
                this.test = 1
                window.addEventListener('message', event => {
                    var loc = event.data;
                    if (loc && loc.module == 'locationPicker') {
                        this.post.longitude = loc.latlng.lng
                        this.post.latitude = loc.latlng.lat
                        this.post.address = loc.poiaddress
                    }
                }, false);
            },
            async doResetForm() {
                await this.$refs['form'].resetFields();
            },
            uploadSuccess(res) {
                this.post.img = res.file
            },
            uploadRemove(res) {
                this.post.img = null
            }
        }
    }
</script>