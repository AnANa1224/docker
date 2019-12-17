<template>
    <!-- MAIN -->
    <div class="main">

        <div class="container">
            <div class="main-content-head">
                <h2>分类管理</h2>
                <p>Welcome to my Admin</p>
            </div>
        </div>
        <div class="shows">
            <div class="container">
                    <div class="box">
                        <div class="box-head">
                            <h2>所有分类信息</h2>
                            <p @click="local('createCategory','')">新增分类</p>
                        </div>
                        <div class="item">
                            <div class="item-responsive ">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>编号</th>
                                            <th>分类名称</th>
                                            <th>分类属性</th>
                                            <th>分类状态</th>
                                            <th>相关操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(category,index) in categorys">
                                            <td>
                                                <a class="el-link el-link--success is-underline" @click="local('detailCategory',category.id)">
                                                    <span class="el-link--inner">
                                                        {{(page-1)*10+index+1}}
                                                        <i class="el-icon-view el-icon--right"></i>
                                                    </span>
                                                </a>
                                            </td>
                                            <td>{{category.name}}</td>
                                            <td>
                                                <span v-if="category.property == null">无</span>
                                                <span v-else v-for=" att in category.property">{{att}} </span>
                                            </td>
                                            <td>
                                                <span @click="editStatus(index,2)" v-if="category.status === 1" class="item-status delivered">显示</span>
                                                <span @click="editStatus(index,1)" v-if="category.status === 2" class="item-status cancel">隐藏</span>
                                            </td>
                                            <td>
                                                <span class="item-status delivered" @click="local('editCategory',category.id)">UPDATE</span>
                                                <span class="item-status cancel" @click="modal1 = true,id = category.id">DELETE</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div v-if="catePages.pageCount !== 1" class="demo-block demo-zh-CN demo-pagination">
                            <div class="source">
                                <div>
                                    <div class="block">
                                        <div class="el-pagination">
                                            <span class="el-pagination__total">共 {{catePages.itemCount}}条</span>
                                            <button v-if="catePages.currentPage === 1" disabled="disabled" type="button" class="btn-prev">
                                                <i class="el-icon el-icon-arrow-left"></i>
                                            </button>
                                            <button v-else @click="switchPage(catePages.prevPage)" type="button" class="btn-next">
                                                <i class="el-icon el-icon-arrow-left"></i>
                                            </button>
                                            <ul class="el-pager">
                                                <li v-for="p in pages" v-if="p === catePages.currentPage" class="number active">
                                                    {{p}}
                                                </li>
                                                <li v-else class="number" @click="switchPage(p)">
                                                    {{p}}
                                                </li>
                                            </ul>
                                            <button v-if="catePages.currentPage === catePages.pageCount" disabled="disabled" type="button" class="btn-prev">
                                                <i class="el-icon el-icon-arrow-right"></i>
                                            </button>
                                            <button v-else @click="switchPage(catePages.nextPage)" type="button" class="btn-next">
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
                <p>这将影响到该分类下的所有商品。</p>
                <p>是否继续删除？</p>
            </div>
            <div slot="footer">
                <Button type="error" size="large" long :loading="modal_loading" @click="del">删除</Button>
            </div>
        </Modal>

    </div>
    <!-- END MAIN -->
</template>

<script>
    import axios from 'axios'
    export default {
        name: "Category",
        data () {
            return {
                id:'',
                apiUrl:'',
                categorys:[],
                disabled:true,
                notice:'',  // 提示信息
                modal1: false, // 确认弹框
                modal_loading: false, // 加载ing
                pages:[], // 页
                page:1, // 当前页
                catePages:{}, // 分页信息
            };
        },
        mounted(){
            this.getCateMes();
            this.apiUrl = global.origin;
        },
        methods: {
            getCateMes(){
                this.handleSpinCustom();
                axios({
                    method:'get',
                    url:this.apiUrl+'/api/category',
                    params:{
                        page:this.page,
                    },
                    responseType:'json'
                }).then(res => {
                    if (res.data.code === 0) {
                        // console.log(res.data);
                        this.categorys = res.data.data;
                        this.catePages = res.data.page;
                        let pageCount = this.catePages.pageCount;
                        this.pages = [];
                        for (let i = 1; i <= pageCount ; i++){
                            this.pages.push(i);
                        }
                    } else {
                        this.notice = res.data.msg;
                        this.error(false);
                    }
                    this.$Spin.hide();
                });
            },
            editStatus(index,status){
                this.handleSpinCustom();
                this.categorys[index].status = status;
                axios({
                    method:'put',
                    url:this.apiUrl+'/api/category/update',
                    params:this.categorys[index],
                    responseType:'json',
                }).then( res => {
                    this.$Spin.hide();
                    // this.getProductMsg();
                });
            },
            del(){
                this.modal_loading = true;
                this.delCate();
            },
            delCate(){
                axios({
                    method:'delete',
                    url:this.apiUrl+'/api/category/delete',
                    params:{
                        id:this.id,
                    },
                    responseType:'json'
                }).then(res => {
                    this.modal_loading = false;
                    this.modal1 = false;
                    this.notice = res.data.msg;
                    if (res.data.code === 0){
                        this.success(false);
                    } else {
                        this.error(false);
                    }
                    this.getCateMes();
                });
            },
            local(uri,id){
                this.active = uri;
                if (id === '') {
                    this.$router.push({path:'/'+uri});
                } else {
                    this.$router.push({path:'/'+uri,query:{id:id}});
                }
            },
            switchPage(page){
                this.page = page;
                this.getCateMes();
            },
            changePage(ev){
                let keynum = ev.keyCode;
                let keychar = String.fromCharCode(keynum);
                // console.log(keynum,keychar);
                // 回车13
                if (keynum === 13){
                    this.page > this.catePages.pageCount ? this.page = this.catePages.pageCount : null ;
                    this.page < 1 ? this.page = 1 : null ;
                    this.getCateMes();
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
            }
        }
    }
</script>

<style scoped>
    .shows{
        margin-top: 20px;
    }
    .add ,.edit ,.detail{
        padding: 20px;
        text-align: center;
    }
    .add .container, .edit .container, .detail .container{
        background: #fff;
    }
    .addAttr{
        display: inline-block;
        padding: 0 10px;
        cursor: pointer;
        line-height: 40px;
        background: #f6f6f6;
        border-radius: 10px;
        margin-left: 20px;
    }
    .attrs{
        float: left;
        height: 40px;
        padding-top: 5px;
    }
    .attr{
        float: left;
        line-height: 20px;
        padding: 5px 20px;
        border-radius: 20px;
        background: #fff;
        margin-left: 10px;
    }
    .forms{
        display: inline-block;
    }
</style>
