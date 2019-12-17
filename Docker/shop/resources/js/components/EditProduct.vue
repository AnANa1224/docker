<template>
    <!-- MAIN -->
    <div class="main">

        <div class="container">
            <div class="main-content-head">
                <h2>商品管理</h2>
                <p>Welcome to my Admin</p>
            </div>
        </div>

        <div class="edit">
            <div class="container">
                <div class="demo-block">
                    <div class="source">
                        <div class="el-page-header">
                            <div @click="local('product')" class="el-page-header__left">
                                <i class="el-icon-back"></i>
                                <div class="el-page-header__title">首页</div>
                            </div>
                            <div class="el-page-header__content ma">修改商品</div>
                            <div class="el-page-header__content" style="margin-left: 24px;">
                                <button @click="modal1 = true" type="button" class="el-button el-button--danger is-circle" style="padding: 3px;">
                                    <i class="el-icon-delete"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="forms">
                    <form class="el-form">
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">商品名称</label>
                            <input v-model="proMsg.name" type="text" autocomplete="off" style="width: 300px;" class="el-input__inner" placeholder="请输入商品名称">
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">商品分类</label>
                            <select @click="notice='暂不可修改分类',warning(false)" v-model="proMsg.category_id" disabled="disabled" name="edit_cate" id="edit_cate" style="width: 300px; height: 40px">
                                <option :value="cateMsg.id">{{cateMsg.name}}</option>
                            </select>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">商品描述</label>
                            <input v-model="proMsg.content" type="text" autocomplete="off" style="width: 300px;" class="el-input__inner" placeholder="请填写描述">
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">保质/修期</label>
                            <select v-model.number="proMsg.lift" name="status" style="width: 300px; height: 40px">
                                <option value="">按需选择 (可不选)</option>
                                <option value="30">30天</option>
                                <option value="45">45天</option>
                                <option value="90">3个月</option>
                                <option value="180">6个月</option>
                                <option value="360">1年</option>
                            </select>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">商品排序</label>
                            <select v-model.number="proMsg.sort" name="sort" id="edit_sort" style="width: 300px; height: 40px">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">商品状态</label>
                            <select v-model.number="proMsg.status" name="status" id="edit_status" style="width: 300px; height: 40px">
                                <option value="1">显示</option>
                                <option value="2">隐藏</option>
                                <option value="3">删除</option>
                            </select>
                        </div>
                        <div class="el-form-item">
                            <label class="el-form-item__label" style="width: 80px;">宣传语句</label>
                            <textarea v-model="proMsg.propaganda" autocomplete="off" placeholder="请输入内容" maxlength="3000" class="el-textarea__inner" style="width: 300px;min-height: 70px;display:inline-block;"></textarea>
                        </div>
                        <div class="el-form-item" style="text-align: initial;">
                            <div class="source">
                                <div>
                                    <div>
                                        <ul v-if="fileKeys.length>0" class="el-upload-list el-upload-list--picture-card">
                                            <li v-for="(imgUrl,index) in fileKeys" tabindex="0" class="el-upload-list__item is-success">
                                                <img :src="imgUrl" alt="" class="el-upload-list__item-thumbnail">
                                                <i class="el-icon-close"></i>
                                                <span class="el-upload-list__item-actions">
                                                        <span @click="bigImg(imgUrl)" class="el-upload-list__item-preview">
                                                            <i class="el-icon-zoom-in"></i>
                                                        </span>
                                                        <span @click="delProImg(index)" class="el-upload-list__item-delete">
                                                            <i class="el-icon-delete"></i>
                                                        </span>
                                                    </span>
                                            </li>
                                        </ul>
                                        <label for="img" tabindex="0" class="el-upload el-upload--picture-card">
                                            <i class="el-icon-plus"></i>
                                            <input @change="uploadImg($event)" type="file" name="file" id="img" class="el-upload__input" style="display: none">
                                        </label>
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
                            <div class="el-form-item__content" style="margin-left: 80px;">
                                <button type="button" class="el-button el-button--primary" style="width: 300px;" @click="editPro"><span>更新</span></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="source" style="display:inline-block;margin-bottom: 100px;">
                    <h3 style="margin: 55px 0 20px;">商品属性库存信息</h3>
                    <div v-if="attr1" class="el-form-item">
                        <h3 class="sku_title"><span>{{attr1}}</span></h3>
                        <div class="sku_attr">
                            <span v-for="(a,index) in attrs1" class="el-tag el-tag--dark">
                                {{a.attr1}}
                                <i class="el-tag__close el-icon-close" @click="delSkuAttr('attr1',index)"></i>
                            </span>
                            <input v-model="sku_attrs1.attr1" type="text" autocomplete="off" placeholder="属性名" class="el-input__inner" style="width: 80px;">
                            <span @click="addSkuAttr1" class="el-tag el-tag--warning el-tag--dark cp">添加</span>
                        </div>
                    </div>
                    <div v-if="attr2" class="el-form-item">
                        <h3 class="sku_title"><span>{{attr2}}</span></h3>
                        <div class="sku_attr">
                            <span v-for="(a,index) in attrs2" class="el-tag el-tag--dark">
                                {{a.attr2}}
                                <i class="el-tag__close el-icon-close" @click="delSkuAttr('attr2',index)"></i>
                            </span>
                            <input v-model="sku_attrs2.attr2" type="text" autocomplete="off" placeholder="属性名" class="el-input__inner" style="width: 80px;">
                            <span @click="addSkuAttr2" class="el-tag el-tag--warning el-tag--dark cp">添加</span>
                        </div>
                    </div>
                    <div v-if="attr3" class="el-form-item">
                        <h3 class="sku_title"><span>{{attr3}}</span></h3>
                        <div class="sku_attr">
                            <span v-for="(a,index) in attrs3" class="el-tag el-tag--dark">
                                {{a.attr3}}
                                <i class="el-tag__close el-icon-close" @click="delSkuAttr('attr3',index)"></i>
                            </span>
                            <input v-model="sku_attrs3.attr3" type="text" autocomplete="off" placeholder="属性名" class="el-input__inner" style="width: 80px;">
                            <span @click="addSkuAttr3" class="el-tag el-tag--warning el-tag--dark cp">添加</span>
                        </div>
                    </div>
                    <div>
                        <div v-if="skusList" class="el-table el-table--fit el-table--border el-table--scrollable-y el-table--enable-row-hover el-table--enable-row-transition" style="width: 100%; height: 325px;">
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
                                        <th colspan="1" rowspan="1" class="is-leaf sky_item" style="width: 60px;"><div class="cell">操作</div></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="el-table__body-wrapper is-scrolling-none" style="height: 267px;">
                                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 802px;">
                                    <tbody>
                                    <tr v-for="(sku,index) in skuMsg" class="el-table__row">
                                        <td v-if="attr1" rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.attr1}}</div></td>
                                        <td v-if="attr2" rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.attr2}}</div></td>
                                        <td v-if="attr3" rowspan="1" colspan="1" class="sky_item"><div class="cell">{{sku.attr3}}</div></td>
                                        <td rowspan="1" colspan="1" class="sky_item">
                                            <div class="cell">
                                                <input v-model.number="sku.original_price" type="text" autocomplete="off" class="el-input__inner sku_ipt" placeholder="单价">
                                            </div>
                                        </td>
                                        <td rowspan="1" colspan="1" class="sky_item">
                                            <div class="cell">
                                                <input v-model.number="sku.price" type="text" autocomplete="off" class="el-input__inner sku_ipt" placeholder="售价">
                                            </div>
                                        </td>
                                        <td rowspan="1" colspan="1" class="sky_item">
                                            <div class="cell">
                                                <input v-model.number="sku.quantity" type="text" autocomplete="off" class="el-input__inner sku_ipt" placeholder="库存">
                                            </div>
                                        </td>
                                        <td rowspan="1" colspan="1" class="sky_item">
                                            <div class="cell">
                                                <select v-model.number="sku.sort" name="sort" style="width: 100%; height: 40px">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td rowspan="1" colspan="1" class="sky_item">
                                            <div class="cell">
                                                <select v-model.number="sku.status" name="status" style="width: 100%; height: 40px">
                                                    <option value="1">显示</option>
                                                    <option value="2">隐藏</option>
                                                    <option value="3">删除</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td rowspan="1" colspan="1" class="sky_item" style="width: 60px;">
                                            <div class="cell">
                                                <button @click="delSku(index)" type="button" class="el-button el-button--danger is-circle">
                                                    <i class="el-icon-delete"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="el-table__column-resize-proxy" style="display: none;"></div>
                        </div>
                        <div v-else class="el-table el-table--fit el-table--border el-table--scrollable-y el-table--enable-row-hover el-table--enable-row-transition" style="width: 100%; height: 104px;">
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
                                        <th colspan="1" rowspan="1" class="is-leaf sky_item" style="width: 60px;"><div class="cell">操作</div></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="el-table__body-wrapper is-scrolling-none" style="height: 50px;">
                                <table cellspacing="0" cellpadding="0" border="0" class="el-table__body" style="width: 802px;">
                                    <tbody>
                                    <tr>
                                        <td style="text-align: center;" colspan="7">暂无数据</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="el-table__column-resize-proxy" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="el-form-item" style="margin-top: 50px;">
                        <div class="el-form-item__content">
                            <button @click="editPro" type="button" class="el-button el-button--primary" style="width: 300px;"><span>保存</span></button>
                        </div>
                    </div>
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
        name: "EditProduct",
        data() {
            return {
                product_id:Number,
                apiUrl:'',
                categorys:[],
                cateAttrs:[],
                attrList:false,
                tag_sku:'sku',
                skusList:false,
                proMsg:{},
                cateMsg:{},
                // 分类数据
                attr1:'',
                attr2:'',
                attr3:'',
                attrDel:[],
                skuMsg:[],
                skus:[],
                sku:{},
                sku_attrs1:{attr1:'',original_price:null,price:null,quantity:null,sort:10,status:1},
                attrs1:[],
                sku_attrs2:{attr2:''},
                attrs2:[],
                sku_attrs3:{attr3:''},
                attrs3:[],
                notice:'',  // 提示信息
                modal1: false, // 确认弹框
                modal_loading: false,
                tag_content:'',
                tag_lift:'',
                fileKeys:[],
                bigImgList:false,
                bigImgMsg:{},

            }
        },
        mounted() {
            this.product_id = this.$route.query.id;
            this.apiUrl = global.origin;
            this.getCateMes();
            this.proDetail(this.product_id);
        },
        methods: {
            getCateMes(){
                axios({
                    method:'get',
                    url:this.apiUrl+'/api/category',
                    responseType:'json'
                }).then(res => {
                    if (res.data.code === 0) {
                        // console.log(res.data.data);
                        this.categorys = res.data.data;
                    } else {

                    }
                });
            },
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
                        this.attrs1 = [];
                        this.attrs2 = [];
                        this.attrs3 = [];
                        let a1 = [];
                        let a2 = [];
                        let a3 = [];
                        for(let [index,sku] of this.skuMsg.entries()) {
                            if (sku.attr1 !== '') {
                                a1.push(sku.attr1);
                            }
                            if (sku.attr2 !== '') {
                                a2.push(sku.attr2);
                            }
                            if (sku.attr3 !== '') {
                                a3.push(sku.attr3);
                            }
                        }
                        a1 = Array.from(new Set(a1));
                        // console.log(a1);
                        for (let attr of a1){
                            this.attrs1.push({product_id:this.product_id,attr1:attr,original_price:0.00,price:0.00,quantity:0,sort:10,status:1});
                        }
                        a2 = Array.from(new Set(a2));
                        for (let attr of a2){
                            this.attrs2.push({attr2:attr});
                        }
                        a3 = Array.from(new Set(a3));
                        for (let attr of a3){
                            this.attrs3.push({attr3:attr});
                        }
                    }
                    if (this.cateMsg.property.attr1){
                        this.attrList = true;
                        this.attr1 = this.cateMsg.property.attr1;
                        this.attr2 = this.cateMsg.property.attr2 ? this.cateMsg.property.attr2 : '';
                        this.attr3 = this.cateMsg.property.attr3 ? this.cateMsg.property.attr3 : '';
                    }
                    this.$Spin.hide();
                    this.attrDel = [];
                });
            },
            addSkuAttr1(){
                if (this.attr1 && this.sku_attrs1.attr1 === '') {
                    this.notice = this.attr1+'属性不能为空';
                    this.warning(false);
                    return false;
                }
                for (let at1 of this.attrs1){
                    if (at1.attr1 === this.sku_attrs1.attr1){
                        this.notice = '已有该属性';
                        this.warning(false);
                        return false;
                    }
                }
                this.attrs1.push(this.sku_attrs1);
                if (this.attr1 && !this.attr2 && !this.attr3) {
                    this.skuMsg.push(this.sku_attrs1);
                }
                if (this.attrs1.length>0 && this.attrs2.length>0 && this.attr3 === '') {
                    for (let a2 of this.attrs2) {
                        let sku = {};
                        sku.product_id = this.product_id;
                        sku.original_price = this.sku_attrs1.original_price;
                        sku.price = this.sku_attrs1.price;
                        sku.attr1 = this.sku_attrs1.attr1;
                        sku.attr2 = a2.attr2;
                        sku.quantity = 0;
                        sku.sort = this.sku_attrs1.sort;
                        sku.status = this.sku_attrs1.status;
                        this.skuMsg.push(sku);
                    }
                } else if (this.attrs1.length>0 && this.attrs2.length>0 && this.attrs3.length>0) {
                    for (let a2 of this.attrs2) {
                        for (let a3 of this.attrs3) {
                            let sku = {};
                            sku.product_id = this.product_id;
                            sku.original_price = this.sku_attrs1.original_price;
                            sku.price = this.sku_attrs1.price;
                            sku.attr1 = this.sku_attrs1.attr1;
                            sku.attr2 = a2.attr2;
                            sku.attr3 = a3.attr3;
                            sku.quantity = 0;
                            sku.sort = this.sku_attrs1.sort;
                            sku.status = this.sku_attrs1.status;
                            this.skuMsg.push(sku);
                        }
                    }
                }
                this.sku_attrs1 = {attr1:'',original_price:null,price:null,quantity:null,sort:10,status:1};
                this.skusList = true;
            },
            addSkuAttr2(){
                if (this.attr2 && this.sku_attrs2.attr2 === '') {
                    this.notice = this.attr2+'属性不能为空';
                    this.warning(false);
                    return false;
                }
                for (let at2 of this.attrs2){
                    if (at2.attr2 === this.sku_attrs2.attr2){
                        this.notice = '已有该属性';
                        this.warning(false);
                        return false;
                    }
                }
                this.attrs2.push(this.sku_attrs2);
                if (this.attrs1.length>0 && this.attrs2.length>0 && this.attr3 === '') {
                    for (let a1 of this.attrs1) {
                        let sku = {};
                        sku.product_id = this.product_id;
                        sku.original_price = a1.original_price;
                        sku.price = a1.price;
                        sku.attr1 = a1.attr1;
                        sku.attr2 = this.sku_attrs2.attr2;
                        sku.quantity = 0;
                        sku.sort = a1.sort;
                        sku.status = a1.status;
                        this.skuMsg.push(sku);
                    }
                } else if (this.attrs1.length>0 && this.attrs2.length>0 && this.attrs3.length>0) {
                    for (let a1 of this.attrs1) {
                        for (let a3 of this.attrs3) {
                            let sku = {};
                            sku.product_id = this.product_id;
                            sku.original_price = a1.original_price;
                            sku.price = a1.price;
                            sku.attr1 = a1.attr1;
                            sku.attr2 = this.sku_attrs2.attr2;
                            sku.attr3 = a3.attr3;
                            sku.quantity = 0;
                            sku.sort = a1.sort;
                            sku.status = a1.status;
                            this.skuMsg.push(sku);
                        }
                    }
                }
                this.sku_attrs2 = {attr2:''};
                this.skusList = true;
            },
            addSkuAttr3(){
                if (this.attr3 && this.sku_attrs3.attr3 === '') {
                    this.notice = this.attr3+'属性不能为空';
                    this.warning(false);
                    return false;
                }
                for (let at3 of this.attrs3){
                    if (at3.attr3 === this.sku_attrs3.attr3){
                        this.notice = '已有该属性';
                        this.warning(false);
                        return false;
                    }
                }
                this.attrs3.push(this.sku_attrs3);
                if (this.attrs1.length>0 && this.attrs2.length>0) {
                    for (let a1 of this.attrs1) {
                        for (let a2 of this.attrs2) {
                            let sku = {};
                            sku.product_id = this.product_id;
                            sku.original_price = a1.original_price;
                            sku.price = a1.price;
                            sku.attr1 = a1.attr1;
                            sku.attr2 = a2.attr2;
                            sku.attr3 = this.sku_attrs3.attr3;
                            sku.quantity = 0;
                            sku.sort = a1.sort;
                            sku.status = a1.status;
                            this.skuMsg.push(sku);
                        }
                    }
                }
                this.sku_attrs3 = {product_id:this.product_id,attr3:''};
                this.skusList = true;
            },
            addSkus(){
                this.handleSpinCustom();
                axios({
                    method:'post',
                    url:this.apiUrl+'/api/product/sku/create',
                    params:this.skuMsg,
                }).then(res => {
                    // console.log(res);
                    this.notice = res.data.msg;
                    if (res.data.code === 0){
                        this.success(false);
                    } else {
                        this.error(false);
                    }
                    this.$Spin.hide();
                });
            },
            editPro(){
                this.handleSpinCustom();
                axios({
                    method:'put',
                    url:this.apiUrl+'/api/product/update',
                    params:{
                        id:this.product_id,
                        category_id:this.proMsg.category_id,
                        name:this.proMsg.name,
                        content:this.proMsg.sort,
                        sort:this.proMsg.sort,
                        status:this.proMsg.status,
                    },
                    responseType:'json',
                }).then( res => {
                    this.delAttr();
                    this.addSkus();
                });
            },
            editTags(){
                let image_keys = '';
                if (this.fileKeys !== null){
                    image_keys = this.fileKeys.join(',');
                }
                axios({
                    method:"put",
                    url:this.apiUrl+'/api/product/tag/update',
                    params:{
                        product_id:this.product_id,
                        tag_id:1,
                        value:image_keys,
                    },
                    responseType:'json'
                }).then( res=> {
                    // console.log(res.data);
                });
                axios({
                    method:"put",
                    url:this.apiUrl+'/api/product/tag/update',
                    params:{
                        product_id:this.product_id,
                        tag_id:2,
                        value:this.proMsg.propaganda
                    },
                    responseType:'json'
                }).then( res=> {
                    // console.log(res.data);
                });
                axios({
                    method:"put",
                    url:this.apiUrl+'/api/product/tag/update',
                    params:{
                        product_id:this.product_id,
                        tag_id:3,
                        value:this.proMsg.lift
                    },
                    responseType:'json'
                }).then( res=> {
                    // console.log(res.data);
                });
                this.notice = '修改成功';
                this.success(false);
                this.proDetail(this.product_id);
                this.$Spin.hide();
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
            delSku(index){
                if (this.skuMsg[index].status === 3) {
                    this.notice = '已经删除';
                    this.info(false);
                    return true;
                }
                this.skuMsg[index].status = 3;
                this.notice = '删除成功';
                this.success(false);
                /*axios({
                    method:'delete',
                    url:this.apiUrl+'/api/product/sku/delete',
                    params:{
                        id:id,
                    },
                    responseType:'json'
                }).then( res => {
                    this.notice = res.data.msg;
                    this.info(false);
                    if (res.data.data === 0 ){
                        this.proDetail(this.product_id);
                    }
                })*/
            },
            delAttr(){
                axios({
                    method:'delete',
                    url:this.apiUrl+'/api/product/sku/attr/delete',
                    params:this.attrDel,
                    responseType:'json',
                }).then( res => {
                    this.editTags();
                })
            },
            delSkuAttr(attr,index){
                if (attr === 'attr1') {
                    let n = 2;
                    let max = this.attrs2.length * this.attrs3.length;
                    while (Math.pow(2,n) <= max) {
                        n++;
                    }
                    for (let i=0; i<n; i++) {
                        for(let [key,value] of this.skuMsg.entries()){
                            if (value.attr1 === this.attrs1[index].attr1) {
                                this.skuMsg.splice(key,1);
                            }
                        }
                    }
                    if (this.operation === 'edit') {
                        this.attrDel.push({product_id:this.product_id,attr:'attr1',value:this.attrs1[index].attr1});
                    }
                    if (this.attrs1.length === 1) {
                        this.attrs1 = [];
                        this.attrs2 = [];
                        this.attrs3 = [];
                    } else {
                        this.attrs1.splice(index,1);
                    }
                } else if (attr === 'attr2') {
                    let n = 2;
                    let max = this.attrs1.length * this.attrs3.length;
                    while (Math.pow(2,n) <= max) {
                        n++;
                    }
                    for (let i=0; i<n; i++) {
                        for(let [key,value] of this.skuMsg.entries()){
                            if (value.attr2 === this.attrs2[index].attr2) {
                                this.skuMsg.splice(key,1);
                            }
                        }
                    }
                    if (this.operation === 'edit') {
                        this.attrDel.push({product_id:this.product_id,attr:'attr2',value:this.attrs2[index].attr2});
                    }
                    this.attrs2.splice(index,1);
                } else if (attr === 'attr3') {
                    let n = 2;
                    let max = this.attrs1.length * this.attrs2.length;
                    while (Math.pow(2,n) <= max) {
                        n++;
                    }
                    for (let i=0; i<n; i++) {
                        for(let [key,value] of this.skuMsg.entries()){
                            if (value.attr3 === this.attrs3[index].attr3) {
                                this.skuMsg.splice(key,1);
                            }
                        }
                    }
                    if (this.operation === 'edit') {
                        this.attrDel.push({product_id:this.product_id,attr:'attr3',value:this.attrs3[index].attr3});
                    }
                    this.attrs3.splice(index,1);
                }
            },
            uploadImg(e){
                let file = e.target.files[0];
                // console.log(file);
                // 预览
                // let url = URL.createObjectURL(file);
                // this.avatar_url = url;
                let params = new FormData();
                params.append('file', file);
                axios({
                    method:'post',
                    url:this.apiUrl+'/api/upload/images',
                    headers:{
                        'Content-Type': 'multipart/form-data',
                    },
                    data:params,
                    responseType:'json',
                }).then( res => {
                    this.fileKeys.push(res.data.data.thumbnailUrl);
                    // console.log(res.data);
                })
            },
            delImg(index){
                this.fileKeys.splice(index,1);
            },
            delProImg(index){
                this.fileKeys.splice(index,1);
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
    .sku_ipt{
        width: 100%;
        padding: 0;
        padding-left: 5px;
        background: #fafafa;
    }
    select{
        padding-left: 15px !important;
    }
    .edit{
        padding: 20px;
        text-align: center;
    }
    .add .container, .edit .container, .detail .container{
        background: #fff;
    }
    .forms{
        display: inline-block;
    }
    .sky_item{
        width: 80px;
        text-align: center !important;
    }
    .demo-table .demo-table-expand .el-form-item {
        text-align: initial;
        width: 100% !important;
    }
    .sku_title{
        line-height: 30px;
        margin: 20px 40px 10px 0;
        float: left;
        text-align: left;
        width: 120px;
    }
    .sku_attr{
        max-width: 400px;
        line-height: 30px;
        margin: 20px 40px 10px 0;
        float: left;
        text-align: left;
    }
    .el-tag{
        margin-right: 10px !important;
        margin-bottom: 10px !important;
    }
    .cp{
        cursor: pointer;
    }
    .el-message-box{
        width: 100% !important;
        max-width: 420px !important;
    }
</style>
