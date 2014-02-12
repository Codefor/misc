#!/bin/env python
#encoding=utf8


import requests
#import BeautifulSoup
from BeautifulSoup import BeautifulSoup 

for i in xrange(1,273):
    url = "http://news.iresearchad.com/0-%s" % i
    res = requests.get(url)
    if res.status_code == 200:
	t = BeautifulSoup(res.text)
	for j in t.findAll("ul",{"class":"list_14"}):
	    for k in j.findAll("li"):
		aa = k.find("a")
		d = k.find("span").text
		final = "%s\t%s\t%s" % (aa["href"],aa.text,d)
		print final.encode("utf8")
