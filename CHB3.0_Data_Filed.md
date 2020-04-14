## 畅伙伴3.0 平台重构数据字典

> 1.本文档用于平台重构与开发中对数据字段进行说明，注解，以方便开发人员快速了解项目数据结构以及数据关系

> 2.如果你是平台开发人员, 若你在开发过程中对数据字段进行了修改或新增或删除， 请及时更新本文档

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
last_ip		| string 	| 是 | null 	| 最后登录IP
las_time	| timestamp 	| 是 | URl  	| 最后登录时间
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

### 4.用户实名表 (user_realname)

字段 | 类型 | 为空 | 默认值 | 注释 | 其他 
-----|----- | -----|------|-----|-----
id 			| int 		| 否 | Auto |  实名ID 
user_id 	| int 		| 否 | 无 	| 会员ID | 关联User表ID,同步删除
status		| int 		| 否 | 0 	| 实名状态
name		| string	| 否 | null 	| 真实姓名
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
images		| string	| 否 | null 	| 图片地址 
sort		| int 		| 否 | 0 	| 排序权重 
href		| string	| 否 | # 	| 链接地址   
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
sort		| int 		| 否 | 0 	| 排序权重 
code_size	| int		| 否 | 100 	| 二维码大小
code_x		| int		| 否 | 100 	| 二维码X轴位置
code_y		| int		| 否 | 100 	| 二维码Y轴位置        
created_at | timestamp 	| 是 | Null | 添加时间 
updated_at | timestamp 	| 是 | Null | 修改时间
