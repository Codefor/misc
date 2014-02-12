#!/bin/env python
#encoding=utf8

import sys   
reload(sys) 
sys.setdefaultencoding('utf-8')   

import requests
import json
import time


from bs4 import BeautifulSoup 


for i in xrange(0,222):
    url = "http://search.sina.com.cn/?q=%D2%C6%B6%AF%CA%D3%C6%B5&range=all&c=news&sort=time&col=&source=&from=&country=&size=&time=&page=" + str(i)

    print url
    res = requests.get(url)
    if res.status_code == 200:
	txt = res.text.encode("utf8")
	txt = txt.replace("&lt;","<")
	txt = txt.replace("&gt;",">")

	p = BeautifulSoup(txt)
	for item in p.findAll("div",{"class":"r-info"}):
	    a = item.find("a")

	    p1 = item.find("p",{"class":"fgray_time"})
	    if not p1:
		p1 = item.find("span",{"class":"fgray_time"})

	    dt = " ".join(p1.text.split(" ")[-2:])
	    s = "%s,%s,%s" % (a["href"],a.text,dt)
	    print s.encode("utf8")

