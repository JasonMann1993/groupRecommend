<template>
    <div>
        <el-input v-model="text" disabled></el-input>
        <iframe allow="geolocation" width="100%" height="600" frameborder="0" :src="mapUrl" v-if="mapKey && mapUrl">
        </iframe>
    </div>
</template>
<script>

    export default {
        props: {
            longitude: null,
            latitude: null,
            text: null
        },
        data() {
            return {
                mapKey: null,
                address: {}
            }
        },
        computed: {
            mapUrl() {
                let url = "https://apis.map.qq.com/tools/locpicker?search=1&type=1&key=" + this.mapKey + "&referer=myapp"
                if (this.longitude && this.latitude)
                    url += '&coord=' + this.longitude + ',' + this.latitude
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
                this.getMap()
            },
            onSubmit() {
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
                        this.address.longitude = loc.latlng.lng
                        this.address.latitude = loc.latlng.lat
                        this.address.address = loc.poiaddress
                        this.$emit('choose', this.address)
                        this.$emit('close')
                    }
                }, false);
            },

        }
    }
</script>