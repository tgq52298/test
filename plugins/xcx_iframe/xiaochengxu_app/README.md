# 微信小程序

## 项目说明：

- 基于 weui.wxss、es6 前端技术开发
- 基于 [wx-extend](https://github.com/skyvow/wx-extend) 第三方扩展插件（发送请求、Promise API、表单验证）

## 目录结构：

```
m-mall/
  |-assets/                     # 静态文件
     |- images/                 # 图片
     |- plugins/                # 插件
     |- styles/                 # 样式
     |- ...
  |-config.js                   # 配置文件

  |-helpers/                    # 帮助文件
     |- HttpResource.js
     |- HttpService.js
     |- ...
  |-pages/                      # 小程序页面相关文件
      |- start
        |- index.js
        |- index.json
        |- index.wxml
        |- index.wxss
      |- ...
  |-app.js                      # 小程序逻辑
  |-app.json                    # 小程序公共设置
  |-app.wxss                    # 小程序公共样式表
  |-...
```

