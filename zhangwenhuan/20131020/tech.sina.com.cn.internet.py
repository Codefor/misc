#!/bin/env python
#encoding=utf8


import requests
import json
import time


for i in xrange(1,400):
    url = "http://api.roll.news.sina.com.cn/zt_list?channel=tech&cat_3=tech3_hlwqb&show_ext=1&show_all=1&tag=1&format=json&page=%s&show_num=20" % i

    res = requests.get(url)
    if res.status_code == 200:
	t = json.loads(res.text)
	d = t["result"]["data"]
	for j in d:
	    ctime = time.strftime("%Y-%m-%d %H:%M:%S",time.localtime(int(j["createtime"])))
	    final = "%s\t%s\t%s" % (j["url"],j["title"],ctime)
	    print final.encode("utf8")
