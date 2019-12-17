<template>
    <!-- MAIN -->
    <div class="main">

        <div class="container">
            <div class="main-content-head">
                <h2>商品管理</h2>
                <p>Welcome to my Admin</p>
            </div>
        </div>

        <div class="shows">
            <div class="container">
                <div class="box">
                    <div class="box-head">
                        <h2>所有商品信息</h2>
                        <p @click="local('createProduct')">添加商品</p>
                    </div>
                    <div class="item">
                        <div class="item-responsive ">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>编号</th>
                                    <th>商品名称</th>
                                    <th>商品分类</th>
                                    <th>商品状态</th>
                                    <th>相关操作</th>
                                </tr>
                                </thead><!--/thead-->
                                <tbody>
                                <tr v-for="(product,index) in products">
                                    <td>
                                        <a class="el-link el-link--success is-underline" @click="local('detailProduct',product.id)">
                                            <span class="el-link--inner">
                                                {{(page-1)*10+index+1}}
                                                <i class="el-icon-view el-icon--right"></i>
                                            </span>
                                        </a>
                                    </td>
                                    <td>{{product.name}}</td>
                                    <td>{{product.category_name}}</td>
                                    <td>
                                        <span @click="editStatus(index,2)" v-if="product.status === 1" class="item-status delivered">显示</span>
                                        <span @click="editStatus(index,1)" v-if="product.status === 2" class="item-status cancel">隐藏</span>
                                    </td>
                                    <td>
                                        <span class="item-status delivered" @click="local('editProduct',product.id)">UPDATE</span>
                                        <span class="item-status cancel" @click="del(product.id)">DELETE</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div v-if="proPages.pageCount !== 1" class="demo-block demo-zh-CN demo-pagination">
                        <div class="source">
                            <div>
                                <div class="block">
                                    <div class="el-pagination">
                                        <span class="el-pagination__total">共 {{proPages.itemCount}}条</span>
                                        <button v-if="proPages.currentPage === 1" disabled="disabled" type="button" class="btn-prev">
                                            <i class="el-icon el-icon-arrow-left"></i>
                                        </button>
                                        <button v-else @click="switchPage(proPages.prevPage)" type="button" class="btn-next">
                                            <i class="el-icon el-icon-arrow-left"></i>
                                        </button>
                                        <ul class="el-pager">
                                            <li v-for="p in pages" v-if="p === proPages.currentPage" class="number active">
                                                {{p}}
                                            </li>
                                            <li v-else class="number" @click="switchPage(p)">
                                                {{p}}
                                            </li>
                                        </ul>
                                        <button v-if="proPages.currentPage === proPages.pageCount" disabled="disabled" type="button" class="btn-prev">
                                            <i class="el-icon el-icon-arrow-right"></i>
                                        </button>
                                        <button v-else @click="switchPage(proPages.nextPage)" type="button" class="btn-next">
                                            <i class="el-icon el-icon-arrow-right"></i>
                                        </button>
                                        <span class="el-pagination__jump">
                                                前往
                                                <div class="el-input el-pagination__editor is-in-pagination">
                                                    <input @keydown="changePage($event)" v-model="page" type="number" autocomplete="off" min="1" max="4" class="el-input__inner">
                                                </div>
                                                页
                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  删除确认弹框-->
        <Modal v-model="modal1" width="360">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="ios-information-circle"></Icon>
                <span>确认删除</span>
            </p>
            <div style="text-align:center">
                <p>您确定要删除该商品吗?</p>
            </div>
            <div slot="footer">
                <Button type="error" size="large" long :loading="modal_loading" @click="delPro">删除</Button>
            </div>
        </Modal>
    </div>
    <!-- END MAIN -->
</template>

<script>
    import axios from 'axios'
    export default {
        name: "Product",
        data () {
            return {
                apiUrl: '',
                products:[],
                pages:[], // 页
                page:1, // 当前页
                proPages:{}, // 分页信息
                categorys:[],
                delId:Number,
                notice:'',  // 提示信息
                modal1: false, // 确认弹框
                modal_loading: false,
            };
        },
        mounted(){
            this.getProductMsg();
            this.apiUrl = global.origin;
        },
        methods: {
            getProductMsg(){
                this.handleSpinCustom();
                axios({
                    method:'get',
                    url:this.apiUrl+'/api/product',
                    params:{
                        page:this.page,
                    },
                    responseType:'json',
                }).then(res=>{
                    this.products = res.data.data;
                    this.proPages = res.data.page;
                    // console.log(res.data);
                    let pageCount = this.proPages.pageCount;
                    this.pages = [];
                    for (let i = 1; i <= pageCount ; i++){
                        this.pages.push(i);
                    }
                    this.$Spin.hide();
                });
            },
            editStatus(index,status){
                this.handleSpinCustom();
                this.products[index].status = status;
                axios({
                    method:'put',
                    url:this.apiUrl+'/api/product/update',
                    params:this.products[index],
                    responseType:'json',
                }).then( res => {
                    this.$Spin.hide();
                    // this.getProductMsg();
                });
            },
            switchPage(page){
                this.page = page;
                this.getProductMsg();
            },
            changePage(ev){
                let keynum = ev.keyCode;
                let keychar = String.fromCharCode(keynum);
                // console.log(keynum,keychar);
                // 回车13
                if (keynum === 13){
                    this.page > this.proPages.pageCount ? this.page = this.proPages.pageCount : null ;
                    this.page < 1 ? this.page = 1 : null ;
                    this.getProductMsg();
                }
            },
            del(id){
                this.delId = id;
                this.modal1 = true;
            },
            delPro(){
                this.modal_loading = true;
                axios({
                    method:'delete',
                    url:this.apiUrl+'/api/product/delete',
                    params:{
                        id:this.product_id,
                    },
                    responseType:'json'
                }).then( res => {
                    this.modal_loading = false;
                    this.modal1 = false;
                    this.notice = res.data.msg;
                    if (res.data.code === 0){
                        this.success(false);
                        this.getProductMsg();
                    } else {
                        this.error(false);
                    }
                })
            },
            local(uri,id){
                this.active = uri;
                if (id === '') {
                    this.$router.push({path:'/'+uri});
                } else {
                    this.$router.push({path:'/'+uri,query:{id:id}});
                }
            },
            info (nodesc) {
                this.$Notice.info({
                    title: '友情提示',
                    desc: nodesc ? '' : this.notice,
                });
            },
            success (nodesc) {
                this.$Notice.success({
                    title: '成功提示',
                    desc: nodesc ? '' : this.notice,
                });
            },
            warning (nodesc) {
                this.$Notice.warning({
                    title: '警告',
                    desc: nodesc ? '' : this.notice,
                });
            },
            error (nodesc) {
                this.$Notice.error({
                    title: '错误',
                    desc: nodesc ? '' : this.notice,
                });
            },
            handleSpinCustom () {
                this.$Spin.show({
                    render: (h) => {
                        return h('div', [
                            h('Icon', {
                                'class': 'demo-spin-icon-load',
                                props: {
                                    type: 'ios-loading',
                                    size: 18
                                }
                            }),
                            h('div', 'Loading')
                        ])
                    }
                });
            },
        },
    }
</script>

<style scoped>
    select{
        padding-left: 15px !important;
    }
    .shows{
        margin-top: 20px;
    }
</style>
