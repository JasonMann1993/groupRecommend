<template>
    <div>
        <el-form ref="form" :rules="rules" :model="post" label-width="120px" v-loading="pageLoading">
            <el-form-item label="商家名称" prop="name">
                <el-input v-model="post.name"></el-input>
            </el-form-item>
            <el-form-item label="商家描述" prop="desc">
                <el-input v-model="post.desc"></el-input>
            </el-form-item>
            <el-form-item label="商家地址" prop="address" v-if="post.address && mapKey && mapUrl">
                <el-input v-model="post.address" disabled=""></el-input>
                <iframe allow="geolocation" width="100%" height="600" frameborder="0" :src="mapUrl">
                </iframe>
            </el-form-item>
            <el-form-item label="商家洽谈" prop="talk">
                <el-select v-model="post.talk" placeholder="请选择">
                    <el-option v-for="(type, key) in talkText" :key="key" :label="type" :value="parseInt(key)"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="商家星级" prop="star">
                <el-rate v-model="post.star" style="margin-top: 10px;"></el-rate>
            </el-form-item>
            <el-form-item label="负责人" prop="member_id">
                <el-autocomplete
                        v-model="post.member_name"
                        :fetch-suggestions="searchUser"
                        placeholder="请输入关键字"
                        @select="handleSearchUser"
                ></el-autocomplete>
            </el-form-item>
            <el-form-item label="LOGO" prop="logo">
                <upload @success="uploadSuccess" @remove="uploadRemove" :files="post.logo_url"></upload>
            </el-form-item>
            <el-form-item label="排序" prop="order">
                <el-input type="number" v-model="post.order"></el-input>
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
        data() {
            return {
                talkText: {
                    1: '已洽谈',
                    2: '未洽谈',
                },
                post: {},
                rules: {
                    name: [
                        {required: true, message: '请输入名称', trigger: 'blur'},
                    ],
                },
                buttonLoading: false,
                pageLoading: false,
                searchUserLoading: false,
                userLists: [],
                mapKey: null,
                address: {}
            }
        },
        computed: {
            mapUrl() {
                let url = "https://apis.map.qq.com/tools/locpicker?search=1&type=1&key=" + this.mapKey + "&referer=myapp"
                if (this.address.longitude && this.address.latitude)
                    url += '&coord=' + this.address.longitude + ',' + this.address.latitude
                return url
            }
        },
        watch: {
            id() {
                this.doLoad()
            }
        },
        mounted() {
            this.doLoad()
        },
        methods: {
            async doLoad() {
                await this.doResetForm()
                this.getInfo()
                this.getMap()
            },
            getInfo() {
                this.pageLoading = true
                this.$request.get(this.$url.home.shop + '/' + this.id).then(res => {
                    this.pageLoading = false
                    this.post = res.data.data
                    this.shopLists = this.post.businesses
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
                    this.$request.put(this.$url.home.shop + '/' + this.id, this.post).then(res => {
                        this.buttonLoading = false
                        this.$notify({title: '编辑成功', type: 'success'});

                        this.$emit('success')
                        this.$emit('close')
                    }).catch(error => {
                        this.buttonLoading = false
                    });
                })
            },
            getMapKey() {
                this.$request.get(this.$url.home.map_key).then(res => {
                    this.mapKey = res.data.data
                })
            },
            getMap() {
                this.getMapKey()
                window.removeEventListener('message', event => {
                }, false)
                window.addEventListener('message', event => {
                    var loc = event.data;
                    if (loc && loc.module == 'locationPicker') {
                        this.post.longitude = loc.latlng.lng
                        this.post.latitude = loc.latlng.lat
                        this.post.address = loc.poiaddress
                    }
                }, false);
            },
            searchUser(query, cb) {
                this.searchUserLoading = true;
                this.$request.get(this.$url.home.user_search, {params: {keyword: query}}).then(res => {
                    this.searchUserLoading = false
                    this.userLists = res.data.data
                    cb(this.userLists)
                }).catch(error => {
                    this.searchUserLoading = false
                });
            },
            handleSearchUser(item) {
                this.post.member_id = item.id
            },
            doValidate(callback) {
                this.$refs['form'].validate((valid) => {
                    if (valid)
                        return callback()
                    return false;
                });
            },
            async doResetForm() {
                await this.$refs['form'].resetFields();
            },
            uploadSuccess(res) {
                this.post.logo = res.file
            },
            uploadRemove(res) {
                this.post.logo = null
            },
            uploadSuccessQrCode(res) {
                this.post.qr_code = res.file
            },
            uploadRemoveQrCode(res) {
                this.post.qr_code = null
            }
        }
    }
</script>