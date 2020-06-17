## 畅伙伴3.0 平台重构数据字典

> 1.本文档用于平台重构与开发中对数据字段进行说明，注解，以方便开发人员快速了解项目数据结构以及数据关系

> 2.如果你是平台开发人员, 若你在开发过程中对数据字段进行了修改或新增或删除， 请及时更新本文档


### 操盘方与机构方设置表
字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 		| int 		| 否 | Auto | 会员ID |
nickname 	| string 	| 是 | Null | 会员昵称
account 	| string 	| 否 | 无 	| 会员账号
password 	| string 	| 否 | 无 	| 会员密码 | 加密方式
avatar 		| string 	| 是 | URl  	| 会员头像
user_group 	| int 		| 否 | 1		| 会员用户组 | 关联user_groups表ID
parent 		| int	 	| 否 | 0  	| 会员上级ID
active 		| int	 	| 否 | 1  	| 活动状态
operate 	| string 	| 是 | 无  	| 所属操盘方操盘号
api_token 	| string 	| 是 | 无  	| API登录令牌
last_ip		| string 	| 是 | null 	| 最后登录IP
last_time	| timestamp 	| 是 | URl  	| 最后登录时间
created_at 	| timestamp 	| 是 | Null | 添加时间 
updated_at 	| timestamp 	| 是 | Null | 修改时间 

### 1.用户会员表 (users)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 		| int 		| 否 | Auto | 会员ID |
nickname 	| string 	| 是 | Null | 会员昵称
account 	| string 	| 否 | 无 	| 会员账号
password 	| string 	| 否 | 无 	| 会员密码 | 加密方式
avatar 		| string 	| 是 | URl  	| 会员头像
user_group 	| int 		| 否 | 1		| 会员用户组 | 关联user_groups表ID
parent 		| int	 	| 否 | 0  	| 会员上级ID
active 		| int	 	| 否 | 1  	| 活动状态
operate 	| string 	| 是 | 无  	| 所属操盘方操盘号
api_token 	| string 	| 是 | 无  	| API登录令牌
last_ip		| string 	| 是 | null 	| 最后登录IP
last_time	| timestamp 	| 是 | URl  	| 最后登录时间
created_at 	| timestamp 	| 是 | Null | 添加时间 
updated_at 	| timestamp 	| 是 | Null | 修改时间 

### 1.1用户关系表 (user_relations)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 		| int 		| 否 | Auto | 会员ID |
user_id 	| int 		| 否 | Null | 会员ID
parents 	| longText	| 是 | 无 	| 会员上级集合
last_time	| timestamp 	| 是 | URl  	| 最后登录时间
created_at 	| timestamp 	| 是 | Null | 添加时间 
updated_at 	| timestamp 	| 是 | Null | 修改时间 

### 2.用户钱包表 (user_wallets)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto | 钱包ID 
user_id 	| int 		| 否 | 无 	| 会员ID | 关联User表ID,同步删除
cash_blance	| int 		| 否 | 0 	| 会员分润余额 | int类型，单位为:分
return_blance	| int 	| 否 | 0 	| 会员返现余额 | int类型，单位为:分
created_at | timestamp 	| 是 | Null | 添加时间 
updated_at | timestamp 	| 是 | Null | 修改时间

### 3.用户组表 (user_groups)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto | 组ID 
name 		| string 	| 否 | 无 	| 组名称 
level		| int 		| 否 | 0 	| 组级别 | 越大级别越高且唯一
created_at | timestamp 	| 是 | Null | 添加时间 
updated_at | timestamp 	| 是 | Null | 修改时间

### 4.用户实名表 (user_realnames)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto |  实名ID 
user_id 	| int 		| 否 | 无 	| 会员ID | 关联User表ID,同步删除
status		| int 		| 否 | 0 	| 实名状态
name		| string	| 是 | null 	| 真实姓名
idcard		| string	| 是 | null 	| 身份证号
card_before	| string	| 是 | null 	| 身份证正面照片
card_after	| string	| 是 | null 	| 身份证反面照片
created_at | timestamp 	| 是 | Null | 添加时间 
updated_at | timestamp 	| 是 | Null | 修改时间

### 5.轮播图类型表 (plug_types)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto | 类型ID 
name 		| string 	| 否 | 无 	| 分类名称 
active		| int 		| 否 | 1 	| 开启状态 
created_at | timestamp 	| 是 | Null | 添加时间 
updated_at | timestamp 	| 是 | Null | 修改时间

### 6.轮播图表 (plugs)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto | ID 
title 		| string 	| 是 | null 	| 轮播标题 
active		| int 		| 否 | 1 	| 开启状态
type_id		| int 		| 否 | 	 	| 类型ID
images		| string	| 是 | null 	| 图片地址 
sort		| int 		| 否 | 0 	| 排序权重 
href		| string	| 否 | # 	| 链接地址
verify		| int		| 否 | 0 	| 是否审核  
operate		| string	| 否 | 	 	| 所属操盘号     
created_at | timestamp 	| 是 | Null | 添加时间 
updated_at | timestamp 	| 是 | Null | 修改时间

### 7.分享类型表 (share_types)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto | 类型ID 
name 		| string 	| 否 | 无 	| 分类名称 
active		| int 		| 否 | 1 	| 开启状态 
created_at | timestamp 	| 是 | Null | 添加时间 
updated_at | timestamp 	| 是 | Null | 修改时间

### 8.分享素材表 (shares)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto | 分享ID 
title 		| string 	| 是 | null 	| 分享标题 
active		| int 		| 否 | 1 	| 开启状态
images		| string	| 否 | null 	| 素材地址
type_id		| int 		| 否 | 	 	| 类型ID 
sort		| int 		| 否 | 0 	| 排序权重 
code_size	| int		| 否 | 100 	| 二维码大小
code_x		| int		| 否 | 100 	| 二维码X轴位置
code_y		| int		| 否 | 100 	| 二维码Y轴位置
verify		| int		| 否 | 0 	| 是否审核  
operate		| string	| 否 | 	 	| 所属操盘号        
created_at | timestamp 	| 是 | Null | 添加时间 
updated_at | timestamp 	| 是 | Null | 修改时间

### 9 机器类型表 (machines_types)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto | 类型ID
name 		| string 	| 否 | Null 	| 类型名称 
created_at  | timestamp | 是 | Null | 添加时间 
updated_at  | timestamp | 是 | Null | 修改时间

### 9.1 机器厂商表 (machines_factories)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto | 厂家ID
factory_name| string 	| 否 | Null 	| 厂家名称
type_id     | int 		| 否 | Null 	| 所属类型 
created_at  | timestamp | 是 | Null | 添加时间 
updated_at  | timestamp | 是 | Null | 修改时间

### 9.2 机器型号表 (machines_styles)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto | 型号ID
style_name 	| string 	| 否 | Null 	| 型号名称
factory_id  | int 		| 否 | Null 	| 所属厂商 
created_at  | timestamp | 是 | Null | 添加时间 
updated_at  | timestamp | 是 | Null | 修改时间


### 10.机器表 (machines)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto | 机器ID
style_id	| int 		| 否 | 	 	| 型号
user_id		| int 		| 是 | 	 	| 归属人
sn			| string	| 否 | 	 	| 机器序列号
open_state	| tinyint	| 否 | 0	 	| 开通状态
is_self	 	| tinyint	| 否 | 0	 	| 是否是自备机
created_at  | timestamp 	| 是 | Null | 添加时间 
updated_at  | timestamp 	| 是 | Null | 修改时间



### 11.机器划拨记录表 (transfers)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto | 划拨记录ID
machine_id	| int 		| 否 | 	 	| 划拨机器ID
old_user_id	| int 		| 否 | 	 	| 划拨前归属用户
new_user_id	| int 		| 否 | 	 	| 划拨后归属用户
state	 	| tinyint	| 否 |   	| 类型，1划拨，2回拨
created_at | timestamp 	| 是 | Null | 添加时间 
updated_at | timestamp 	| 是 | Null | 修改时间


### 12.商户表 (merchants)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto | 商户ID
code		| int 		| 否 | 	 	| 商户号
name		| string 	| 是 | 	 	| 商户名称
phone		| string  	| 是 | 	 	| 商户电话
trade_amount| int 	 	| 否 | 0	 	| 商户累计交易金额，单位：分
state		| char		| 否 | 1	 	| 商户状态 0:无效, 1:有效, X：注销
created_at | timestamp 	| 是 | Null | 添加时间 
updated_at | timestamp 	| 是 | Null | 修改时间







### 13.交易表 (trades)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto | 交易ID
trade_no	| string	| 否 | 		| 交易流水号
rrn 		| string	| 否 |  		| 参考号
user_id		| int 		| 是 | 	 	| 用户ID
machine_id	| int 		| 是 | 	 	| 机器ID
is_send		| int 		| 否 | 0	 	| 分润发放状态
sn			| string 	| 是 | 	 	| 机器序列号
merchant_code		| int 		| 否 | 	 	| 商户号
amount		| int  		| 否 | 0	 	| 交易金额，单位：分
settle_amount		| int 		| 否 | 0 	| 结算金额，单位：分
cardType	| int 		| 是 | 	 	| 交易卡类型，0贷记卡，1借记卡
trade_time | timestamp	| 是 | Null | 交易时间
trade_post | json 		| 是 | Null | 推送报文
created_at | timestamp 	| 是 | Null | 添加时间 
updated_at | timestamp 	| 是 | Null | 修改时间

### 14.分润表 (cashs_logs)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto | 分润ID
user_id		| int 		| 否 | 	 	| 用户ID
machine_id	| int 		| 否 | 	 	| 机器ID
trade_id	| int 		| 否 | 0	 	| 交易ID
money		| int 		| 否 | 0	 	| 分润金额，单位：分
is_run		| int 		| 否 | 	 	| 1分润，2返现
type		| int 		| 否 | 	 	| 类型，1直营分润，2团队分润，3激活返现，4间推激活返现，5间间推激活返现，6达标返现，7二次达标返现，8三次达标返现，9财商学院推荐奖励
created_at | timestamp 	| 是 | Null | 添加时间 
updated_at | timestamp 	| 是 | Null | 修改时间

### 15.提现表 (withdraws)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto | 提现ID
user_id		| int 		| 否 | 	 	| 用户ID
order_no	| string 	| 否 | 	 	| 订单号
money		| int		| 否 | 0	 	| 提现金额
real_money	| int		| 否 | 0	 	| 实际打款金额
type		| int 		| 否 | 	 	| 类型，1分润提现，2返现提现
state		| int		| 否 | 1	 	| 状态，1待审核，2通过，3驳回
make_state  | int		| 否 | 	 	| 打款状态：1成功，2失败
check_at	| timestamp | 是 | 	 	| 审核时间
created_at | timestamp 	| 是 | Null | 添加时间 
updated_at | timestamp 	| 是 | Null | 修改时间

### 16.提现详细表 (withdraws_datas)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto | ID
order_no	| string 	| 否 | 	 	| 提现订单号
phone		| int 		| 否 | 	 	| 预留手机号
username	| string	| 否 | 	 	| 用户姓名
idcard		| string	| 否 | 	 	| 身份证号
bank		| string	| 否 | 	 	| 银行名称
bank_open	| string	| 是 | 	 	| 开户行
banklink	| string	| 是 | 	 	| 联行号
repay_money	| int		| 是 | 0	 	| 代付系统打款金额
repay_wallet| int		| 是 | 	 	| 代付系统打款钱包
reason		| string	| 是 | 	 	| 说明
created_at | timestamp 	| 是 | Null | 添加时间 
updated_at | timestamp 	| 是 | Null | 修改时间



### 17.文章型表 (article_types)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto | 类型ID 
name 		| string 	| 否 | 无 	| 分类名称 
active		| int 		| 否 | 1 	| 开启状态 
created_at  | timestamp 	| 是 | Null | 添加时间 
updated_at  | timestamp 	| 是 | Null | 修改时间

### 18.文章列表表 (articles)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto | 文章ID 
title 		| string 	| 是 | null 	| 文章标题 
active		| int 		| 否 | 1 	| 开启状态
images		| string	| 否 | null 	| 文章主图
type_id		| int 		| 否 | 	 	| 文章类型
verify		| int		| 否 | 0 	| 是否审核  
operate		| string	| 否 | 	 	| 所属操盘号
content		| longtext	| 否 | Null	| 文章内容          
created_at | timestamp 	| 是 | Null | 添加时间 
updated_at | timestamp 	| 是 | Null | 修改时间


### 19.操盘方设置表 (settings)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 			| 否 | Auto | 类型ID 
operate 	| string 		| 否 | 无    | 操盘方 
created_at  | timestamp 	| 是 | Null | 添加时间 
updated_at  | timestamp 	| 是 | Null | 修改时间
