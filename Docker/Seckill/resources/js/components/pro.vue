<template>
    <div id="main">
        <h1>秒杀</h1>
        <Card style="width:320px;margin: 20px auto;">
            <div style="text-align:center">
                <p>{{proMsg.name}}</p>
                <img src="/images/jin.jpg" width="280">
                <h4 v-if="timeMsg !== '售罄'">限量{{proMsg.quantity}}件</h4>
                <h3>{{timeMsg}}</h3>
            </div>
        </Card>
        <Button @click="purchase()" :type="type" :disabled="disabled">立即购买</Button>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "pro",
        data() {
            return {
                timeMsg: "抢购",
                type: 'info',
                disabled: true,
                proMsg: {},
                user_id: 1,
            }
        },
        mounted() {
            this.getPro(1);
        },
        methods: {
            getPro(id) {
                axios({
                    method: 'get',
                    params: {
                        id: id
                    },
                    url: 'http://www.seckill.com/api/product',
                    responseType: 'json'
                }).then(res => {
                    let s_time = Math.ceil(new Date(res.data.data.start_time).getTime() / 1000);
                    let e_time = Math.ceil(new Date(res.data.data.end_time).getTime() / 1000);
                    let n_time = this.getDateTime();
                    this.proMsg = res.data.data;

                    // 售罄
                    if (parseInt(this.proMsg.quantity) === 0) {
                        this.timeMsg = '售罄';
                        this.disabled = true;
                        return true;
                    }

                    // 结束
                    if (n_time - e_time > 0) {
                        clearInterval(down);
                        this.timeMsg = '抢购结束';
                        this.disabled = false;
                        return true;
                    }

                    // 开始
                    if (n_time - s_time > 0) {
                        this.disabled = false;
                        this.time = e_time - n_time;
                        let down = setInterval(() => {
                            let r = this.getRT(this.time--);
                            this.timeMsg = '距离结束: ' + r;
                        }, 1000);

                        return true;
                    }

                    this.time = s_time - n_time;
                    this.getRT(this.time);
                    let down = setInterval(() => {
                        let r = this.getRT(this.time--);
                        this.timeMsg = '距离开始: ' + r;
                    }, 1000);


                })
            },
            getDateTime() {
                let data = new Date();
                return Math.ceil(data.getTime() / 1000);
            },
            getRT(time) {
                let h = Math.floor(time / 3600);
                if (h < 10) h = '0' + h;
                let m = Math.floor((time - h * 3600) / 60);
                if (m < 10) m = '0' + m;
                let s = time - h * 36000 - m * 60;
                if (s < 10) s = '0' + s;
                return h + ' : ' + m + ' : ' + s;
            },
            purchase() {
                axios({
                    method: 'post',
                    params: {
                        user_id: this.user_id++,
                        product_id: this.proMsg.id,
                        status: 1,
                    },
                    url: 'http://www.seckill.com/api/order/create',
                    responseType: 'json'
                }).then(res => {
                    if (res.data.code === 0) {
                        console.log('抢购成功');
                        this.$router.push({path:'/order',query:{id:res.data.data.id,product_id:res.data.data.product_id}});

                    } else {
                        console.log('抢购失败');
                    }
                })
            }
        }
    }
</script>

<style scoped>
    #main {
        text-align: center;
    }
</style>
