<template>
    <!-- MAIN -->
    <div class="main">

        <div class="container">
            <div class="main-content-head">
                <h2>导航菜单管理</h2>
                <p>Welcome to my Admin</p>
            </div>
        </div>

        <div class="shows">
            <div class="container">
                <div class="box">
                    <Menu mode="horizontal" :theme="theme1" active-name="1">
                        <MenuItem name="1">
                            <div @click="switchType(1,'导航列表')">
                                <Icon type="ios-paper" />
                                导航管理
                            </div>
                        </MenuItem>
                        <MenuItem name="2">
                            <div @click="switchType(2,'广告图列表')">
                                <Icon type="ios-people" />
                                banner管理
                            </div>
                        </MenuItem>
                        <MenuItem name="3">
                            <div @click="switchType(3,'小图列表')">
                                <Icon type="ios-stats" />
                                icon管理
                            </div>
                        </MenuItem>
                        <MenuItem name="4">
                            <div @click="switchType(4,'大图列表')">
                                <Icon type="ios-construct" />
                                大图设置
                            </div>
                        </MenuItem>
                    </Menu>
                    <!--<br>
                    <RadioGroup v-model="theme1">
                        <Radio label="light"></Radio>
                        <Radio label="dark"></Radio>
                        <Radio label="primary"></Radio>
                    </RadioGroup>-->
                    <div class="box-head cl" style="width: 100%;">
                        <h2>{{head.title}}</h2>
                        <p @click="local('createNav')">添加</p>
                    </div>
                    <div class="item">
                        <div class="item-responsive ">
                            <Table :loading="loading" :data="tableData1" :columns="tableColumns1" stripe></Table>
                            <div v-if="navMsgs.length > 0" style="margin: 10px;overflow: hidden">
                                <div style="float: right;">
                                    <Page :total="pageMsg.itemCount" :page-size="pageMsg.pageSize" :current="pageMsg.currentPage" @on-change="changePage" show-elevator></Page>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--  大图  -->
        <div v-if="bigImgList" class="el-dialog__wrapper" style="z-index: 2052;">
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
        <div v-if="bigImgList" class="v-modal" tabindex="0" style="z-index: 2051;"></div>
        <!--  删除确认弹框-->
        <Modal v-model="modal1" width="360">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="ios-information-circle"></Icon>
                <span>确认删除</span>
            </p>
            <div style="text-align:center">
                <p>您确定要删除该条信息吗?</p>
            </div>
            <div slot="footer">
                <Button type="error" size="large" long :loading="modal_loading" @click="del">删除</Button>
            </div>
        </Modal>

    </div>
    <!-- END MAIN -->
</template>

<script>
    import axios from "axios";

    export default {
        name: "Navigation",
        data () {
            return {
                id:Number,
                apiUrl:'',
                head:{type_id:1,title:'导航列表'},
                theme1: 'light',
                tableData1: [],
                tableColumns1: [
                    {
                        title: '编号',
                        key: 'number',
                        render: (h, params) => {
                            return h('div', [
                                (this.page-1)*10+params.row.number,
                                h('Icon', {
                                    props: {
                                        type: 'ios-eye-outline',
                                        size: '18',
                                        color: '#67C23A'
                                    },
                                    style: {
                                        marginLeft: '5px',
                                        cursor: 'pointer'
                                    },
                                    on: {
                                        click: () => {
                                            this.local('detailNav',params.row.action);
                                        }
                                    }
                                }),
                            ]);
                        }
                    },
                    {
                        title: '标题',
                        key: 'title'
                    },
                    {
                        title: '图片',
                        key: 'picture',
                        render: (h, params) => {
                            return h('div', {
                                    style: {
                                        width: '50px',
                                        height: '50px',
                                        background: 'url('+params.row.picture+') no-repeat',
                                        backgroundSize: '50px 50px',
                                        cursor: 'pointer'
                                    },
                                    on: {
                                        click: () => {
                                            this.bigImgMsg = params.row.picture;
                                            this.bigImgList = true;
                                        }
                                    }
                                });
                        }
                    },
                    {
                        title: '链接类型',
                        key: 'link_type',
                        render: (h, params) => {
                            let link_type = parseInt(params.row.link_type);
                            let text = '';
                            if (link_type === 1) {
                                text = '商品分类页';
                            } else if (link_type === 2) {
                                text = '商品购买页';
                            } else if (link_type === 3) {
                                text = '商品活动页';
                            } else if (link_type === 4) {
                                text = '店铺页';
                            }

                            return h('span', {
                            }, text);
                        }
                    },
                    {
                        title: '链接目标',
                        key: 'link_target',
                    },
                    {
                        title: '状态',
                        key: 'status',
                        render: (h, params) => {
                            const row = params.row;
                            row.status = parseInt(row.status);
                            const color = row.status === 1 ? 'primary' : 'warning';
                            const type = row.status === 1 ? 'success' : 'warning';
                            const text = row.status === 1 ? '显示' : '隐藏';
                            /*return h('span', {
                                    props: {
                                        type: 'dot',
                                        color: color
                                    }
                                },text);*/
                            return h('Button', {
                                props: {
                                    type: type,
                                    size: 'small',
                                    class: 'item-status delivered'
                                },
                                style: {
                                    marginRight: '5px'
                                },
                                on: {
                                    click: () => {
                                        this.editStatus(params.row);
                                    }
                                }
                            }, text);

                        }
                    },
                    {
                        title: '操作',
                        key: 'action',
                        width: 180,
                        align: 'center',
                        render: (h, params) => {
                            return h('div', [
                                h('Button', {
                                    props: {
                                        type: 'primary',
                                        size: 'small'
                                    },
                                    style: {
                                        marginRight: '5px'
                                    },
                                    on: {
                                        click: () => {
                                            this.local('editNav',params.row.action);
                                        }
                                    }
                                }, 'UPDATE'),
                                h('Button', {
                                    props: {
                                        type: 'error',
                                        size: 'small'
                                    },
                                    on: {
                                        click: () => {
                                            this.id = params.row.action;
                                            this.modal1 = true;
                                        }
                                    }
                                }, 'DELEETE')
                            ]);
                        }
                    }
                ],
                page:1,
                pageMsg:{},
                loading:false,
                imgUrl:'',
                bigImgList:false,
                bigImgMsg:{},
                navMsgs:[],
                notice:'',
                modal1: false, // 确认弹框
                modal_loading: false,
            }
        },
        mounted(){
            this.apiUrl = global.origin;
            this.getNavMsgs();
        },
        methods: {
            getNavMsgs(){
                this.loading = true;
                axios({
                    method:'get',
                    url: this.apiUrl+'/api/nav',
                    params:{
                        type_id:this.head.type_id,
                        page:this.page
                    },
                    responseType:'json'
                }).then( res => {
                    if (res.data.code === 0){
                        this.navMsgs = res.data.data;
                        // console.log(this.navMsgs);
                        this.pageMsg = res.data.page;
                        if (this.navMsgs !== null) {
                            this.tableData1 = this.mockTableData1();
                        } else {
                            this.tableData1 = [];
                        }
                    }
                    this.loading = false;
                })
            },
            editStatus(data){
                this.handleSpinCustom();
                data.status = data.status === 1 ? 2 : 1;
                axios({
                    method:'put',
                    url:this.apiUrl+'/api/product/update',
                    params:{
                        product_id:data.action,
                        type_id:this.head.type_id,
                        title:data.title,
                        link_type:data.link_type,
                        link_target:data.link_target,
                        picture:data.picture,
                        status:data.status,
                    },
                    responseType:'json',
                }).then( res => {
                    this.$Spin.hide();
                    // this.getProductMsg();
                });
            },
            del(){
                this.modal_loading = true;
                this.delNav();
            },
            delNav(){
                this.modal_loading = true;
                axios({
                    method: 'delete',
                    url: this.apiUrl+'/api/nav/delete',
                    params:{
                        id:this.id,
                    },
                    responseType:'json'
                }).then( res=> {
                    this.notice = res.data.msg;
                    if (res.data.code === 0) {
                        this.success(false);
                        this.getNavMsgs();
                    } else {
                        this.error(false);
                    }
                    this.modal1 = false;
                    this.modal_loading = false;
                })
            },
            switchType(type_id,title){
                this.head.type_id = type_id;
                this.head.title = title;
                this.getNavMsgs();
            },
            mockTableData1(){
                let data = [];
                for (let [index,nav] of this.navMsgs.entries()) {
                    data.push({
                        number: index+1,
                        title: nav.title,
                        picture: nav.picture,
                        link_type: nav.link_type,
                        link_target: nav.link_target,
                        status: nav.status,
                        action: nav.id,
                    })
                }
                return data;
            },
            changePage(e){
                this.page = e;
                this.getNavMsgs();
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
                    duration: 0
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

</style>
