<template>
    <div id="main">
        <h1>下单成功,情尽快支付</h1>
        <Card style="width:320px;margin: 20px auto;">
            <div style="text-align:left">
                <h3>订单号码: {{orderMsg.order}}</h3>
                <h3>商品名称: {{proMsg.name}}</h3>
                <h3>购买数量: 1</h3>
                <h3>支付金额: {{proMsg.price}}</h3>
            </div>
        </Card>
        <Button @click="pay()" :type="type" :disabled="disabled">立即支付</Button>
        <Button @click="cancel()" type="error" :disabled="disabled">取消订单</Button>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "order",
        data() {
            return {
                type: 'info',
                disabled: false,
                proMsg: {},
                orderMsg: {},
                user_id: 1,
            }
        },
        mounted() {
            this.getOrder(this.$route.query.id,this.$route.query.product_id);
            this.getPro(this.$route.query.product_id);
        },
        methods: {
            getOrder(id,pid) {
                axios({
                    method:'get',
                    url:'http://www.seckill.com/api/order/find',
                    params:{
                        product_id:pid,
                        id:id,
                    },
                    responseType:'json',
                }).then(res => {
                    this.orderMsg = res.data.data;
                })
            },
            getPro(id) {
                axios({
                    method: 'get',
                    url: 'http://www.seckill.com/api/product',
                    params: {
                        id: id
                    },
                    responseType: 'json'
                }).then(res => {
                    this.proMsg = res.data.data;
                })
            },
            getDateTime() {
                let data = new Date();
                return Math.ceil(data.getTime() / 1000);
            },
            pay() {
                axios({
                    method:'post',
                    url: 'http://www.seckill.com/api/order/add',
                    params: {
                        id:this.orderMsg.id,
                        user_id: this.orderMsg.user_id,
                        product_id: this.orderMsg.product_id,
                        order: this.orderMsg.order,
                        status: this.orderMsg.status,
                    },
                    responseType: 'json'
                }).then(res => {
                    console.log(res.data.data);
                })
            },
            cancel(){
                axios({
                    method:'delete',
                    url: 'http://www.seckill.com/api/order/cancel',
                    params: {
                        id:this.orderMsg.id,
                        product_id:this.orderMsg.product_id,
                    },
                    responseType: 'json'
                }).then(res => {
                    console.log(res.data.data);
                    this.$router.push({path:'/'});
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
