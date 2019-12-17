<template>
    <!-- MAIN -->
    <div class="main">

        <div class="container">
            <div class="main-content-head">
                <h2>商品管理</h2>
                <p>Welcome to my Admin</p>
            </div>
        </div>

        <div class="detail">
            <div class="container">
                <div class="demo-block">
                    <div class="source">
                        <div class="el-page-header">
                            <div @click="local('product')" class="el-page-header__left">
                                <i class="el-icon-back"></i>
                                <div class="el-page-header__title">首页</div>
                            </div>
                            <div class="el-page-header__content ma">商品详情</div>
                            <div class="el-page-header__content" style="margin-left: 24px;">
                                <button @click="local('editProduct',product_id)" type="button" class="el-button el-button--primary is-circle" style="padding: 3px;">
                                    <i class="el-icon-edit"></i>
                                </button>
                                <button @click="modal1 = true" type="button" class="el-button el-button--danger is-circle" style="padding: 3px;">
                                    <i class="el-icon-delete"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="demo-block demo-zh-CN demo-table">
                    <h3 style="margin: 55px 0 20px;">商品基础信息</h3>
                    <form class="el-form demo-table-expand el-form--label-left el-form--inline ma" style="width: 20%;min-width: 300px;">
                        <div class="el-form-item">
                            <label class="el-form-item__label">商品名称</label>
                            <div class="el-form-item__content">
                                <span>{{proMsg.name}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">商品分类</label>
                            <div class="el-form-item__content">
                                <span>{{cateMsg.name}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">商品描述</label>
                            <div class="el-form-item__content">
                                <span>{{proMsg.content}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">商品销量</label>
                            <div class="el-form-item__content">
                                <span>{{proMsg.sale_num}}</span>
                            </div>
                        </div>
                        <div v-if="attrList" class="el-form-item">
                            <label class="el-form-item__label">商品属性</label>
                            <div class="el-form-item__content">
                                <span v-if="attr1" class="el-tag el-tag--info el-tag--light">{{attr1}}</span>
                                <span v-if="attr2" class="el-tag el-tag--info el-tag--light">{{attr2}}</span>
                                <span v-if="attr3" class="el-tag el-tag--info el-tag--light">{{attr3}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">商品排序</label>
                            <div class="el-form-item__content">
                                <span>{{proMsg.sort}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">商品状态</label>
                            <div class="el-form-item__content">
                                <span>{{proMsg.status}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">创建时间</label>
                            <div class="el-form-item__content">
                                <span>{{proMsg.created_at}}</span>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label">上次修改</label>
                            <div class="el-form-item__content">
                                <span>{{proMsg.updated_at}}</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="el-tabs__nav-scroll">
                    <div v-if="tag_sku==='sku'" class="el-tabs__item is-top" style="color:#409eff;border-bottom: 2px solid #409eff;margin-bottom: 20px;">库存信息</div>
                    <div v-else @click="tag_sku='sku'" class="el-tabs__item is-top">库存信息</div>
                    <div v-if="tag_sku==='tag'" class="el-tabs__item is-top" style="color:#409eff;border-bottom: 2px solid #409eff;margin-bottom: 20px;">标签消息</div>
                    <div v-else @click="tag_sku='tag'" class="el-tabs__item is-top">标签消息</div>
                </div>
                <div v-if="tag_sku==='sku'" style="margin-bottom:100px;">
                    <div v-if="skusList" class="source" style="display:inline-block;margin-bottom: 100px;">
                        <h3 style="margin: 55px 0 20px;font-weight: 700;">商品属性库存信息</h3>
                        <div>
                            <div class="el-table el-table--fit el-table--border el-table--scrollable-y el-table--enable-row-hover el-table--enable-row-transition" style="width: 100%; height: 325px;">
                                <div class="hidden-columns">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div class="el-table__header-wrapper">
                                    <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 802px;">
                                        <thead class="has-gutter">
                                        <tr class="">
                                            <th v-if="attr1" colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">{{attr1}}</div></th>
                                            <th v-if="attr2" colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">{{attr2}}</div></th>
                                            <th v-if="attr3" colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">{{attr3}}</div></th>
                                            <th colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">单价</div></th>
                                            <th colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">售价</div></th>
                                            <th colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">库存</div></th>
                                            <th colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">排序</div></th>
                                            <th colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">状态</div></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="el-table__body-wrapper is-scrolling-none" style="height: 267px;">
                                    <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 802px;">
                                        <tbody>
                                        <tr v-for="sku in skuMsg" class="el-table__row">
                                            <td v-if="attr1" rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.attr1}}</div></td>
                                            <td v-if="attr2" rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.attr2}}</div></td>
                                            <td v-if="attr3" rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.attr3}}</div></td>
                                            <td rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.original_price}}</div></td>
                                            <td rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.price}}</div></td>
                                            <td rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.quantity}}</div></td>
                                            <td rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.sort}}</div></td>
                                            <td rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.status}}</div></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="el-table__column-resize-proxy" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="source" style="display:inline-block;margin-bottom: 100px;">
                        <h3 style="margin: 55px 0 20px;font-weight: 700;">商品属性库存信息</h3>
                        <div>
                            <div class="el-table el-table--fit el-table--border el-table--scrollable-y el-table--enable-row-hover el-table--enable-row-transition" style="width: 100%; height: 104px;">
                                <div class="hidden-columns">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <div class="el-table__header-wrapper">
                                    <table cellspacing="0" cellpadding="0" border="0" class="el-table__header" style="width: 802px;">
                                        <thead class="has-gutter">
                                        <tr class="">
                                            <th v-if="attr1" colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">{{attr1}}</div></th>
                                            <th v-if="attr2" colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">{{attr2}}</div></th>
                                            <th v-if="attr3" colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">{{attr3}}</div></th>
                                            <th colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">单价</div></th>
                                            <th colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">售价</div></th>
                                            <th colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">库存</div></th>
                                            <th colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">排序</div></th>
                                            <th colspan="1" rowspan="1" class="is-leaf sky_item"><div class="cell">状态</div></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="el-table__body-wrapper is-scrolling-none" style="height: 50px;">
                                    <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 802px;">
                                        <tbody>
                                        <tr class="el-table__row">
                                            <td style="text-align: center;" colspan="7">暂无数据</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="el-table__column-resize-proxy" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="tag_sku==='tag'" class="tags">
                    <h3 style="margin: 55px 0 20px;text-align:center;font-weight: 700;">商品其他信息</h3>
                    <form class="el-form">
                        <div class="el-form-item">
                            <h3 style="margin: 30px 0 10px;font-size:22px;">商品图片信息</h3>
                            <div class="source">
                                <div>
                                    <div>
                                        <ul class="el-upload-list el-upload-list--picture-card">
                                            <li v-if="proMsg.imgs" v-for="img in proMsg.imgs" tabindex="0" class="el-upload-list__item is-success">
                                                <img :src="img" alt="" class="el-upload-list__item-thumbnail">
                                                <i class="el-icon-close"></i>
                                                <i class="el-icon-close-tip">按 delete 键可删除</i>
                                                <span class="el-upload-list__item-actions">
                                                        <span @click="bigImg(img)" class="el-upload-list__item-preview">
                                                            <i class="el-icon-zoom-in"></i>
                                                        </span>
                                                    </span>
                                            </li>
                                            <li v-else>
                                                <h4>没有图片信息</h4>
                                            </li>
                                        </ul>
                                    </div>
                                    <div v-if="bigImgList" class="el-dialog__wrapper" style="z-index: 2052">
                                        <div role="dialog" aria-modal="true" aria-label="dialog" class="el-dialog" style="margin-top: 15vh;">
                                            <div class="el-dialog__header">
                                                <span class="el-dialog__title"></span>
                                                <button @click="bigImgList=false" type="button" aria-label="Close" class="el-dialog__headerbtn">
                                                    <i class="el-dialog__close el-icon el-icon-close"></i>
                                                </button>
                                            </div>
                                            <div v-if="bigImgList" class="el-dialog__body">
                                                <img width="100%" :src="bigImgMsg" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="el-form-item">
                            <h3 style="margin: 30px 0 10px;font-size:22px;">商品宣传语</h3>
                            <h4>
                                <span v-if="proMsg.propaganda">{{proMsg.propaganda}}</span>
                                <span v-else>未填写</span>
                            </h4>
                        </div>
                        <div class="el-form-item">
                            <h3 style="margin: 30px 0 10px;font-size:22px;">商品保质期</h3>
                            <h4>
                                <span v-if="proMsg.lift">{{proMsg.lift}}</span>
                                <span v-else>未填写</span>
                            </h4>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--  大图遮罩层  -->
        <div v-if="bigImgList" class="v-modal" tabindex="0" style="z-index: 2051;"></div>
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
    import axios from "axios";

    export default {
        name: "DetailProduct",
        data() {
            return {
                product_id:Number,
                apiUrl:'',
                attrList:false,
                attr1:'',
                attr2:'',
                attr3:'',
                tag_sku:'sku',
                skusList:false,
                proMsg:{},
                cateMsg:{},
                skuMsg:[],
                modal1: false, // 确认弹框
                modal_loading: false,
                fileKeys:[],
                bigImgList:false,
                bigImgMsg:{},
            }
        },
        mounted() {
            this.product_id = this.$route.query.id;
            this.apiUrl = global.origin;
            this.proDetail(this.product_id);
        },
        methods: {
            proDetail(id){
                this.handleSpinCustom();
                axios({
                    method:'get',
                    url:this.apiUrl+'/api/product/detail',
                    params:{
                        id:id,
                    },
                    responseType:'json'
                }).then( res => {
                    // console.log(res.data.data);
                    this.cateDetail(res.data.data);
                });
            },
            cateDetail(data){
                axios({
                    method:'get',
                    url:this.apiUrl+'/api/category/detail',
                    params:{
                        id:data.category_id,
                    },
                    responseType:'json'
                }).then( res => {
                    // console.log(res.data.data);
                    this.cateMsg = res.data.data;
                    this.proMsg = data;
                    // console.log(data);
                    this.proMsg.imgs ? this.fileKeys = this.proMsg.imgs : this.fileKeys = [];
                    this.product_id = data.id;
                    if (this.proMsg.skus && this.proMsg.skus.length>0){
                        this.skusList = true;
                        this.skuMsg = this.proMsg.skus;
                    }
                    if (this.cateMsg.property.attr1){
                        this.attrList = true;
                        this.attr1 = this.cateMsg.property.attr1;
                        this.attr2 = this.cateMsg.property.attr2 ? this.cateMsg.property.attr2 : '';
                        this.attr3 = this.cateMsg.property.attr3 ? this.cateMsg.property.attr3 : '';
                    }
                    this.$Spin.hide();
                });
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
                        this.local('product');
                    } else {
                        this.error(false);
                    }
                })
            },
            bigImg(imgUrl){
                this.bigImgMsg = imgUrl;
                if (this.bigImgMsg) {
                    this.bigImgList = true;
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
            local(uri,id){
                this.active = uri;
                if (id === '') {
                    this.$router.push({path:'/'+uri});
                } else {
                    this.$router.push({path:'/'+uri,query:{id:id}});
                }
            },
        }
    }
</script>

<style scoped>
    select{
        padding-left: 15px !important;
    }
    .detail{
        padding: 20px;
        text-align: center;
    }
    .detail .container{
        background: #fff;
    }
    .sky_item{
        width: 80px;
        text-align: center !important;
    }
    .demo-table .demo-table-expand .el-form-item {
        text-align: initial;
        width: 100% !important;
    }
    .tags{
        padding: 30px 50px;
        text-align: initial !important;
    }
    .el-tag{
        margin-right: 10px !important;
        margin-bottom: 10px !important;
    }
</style>
