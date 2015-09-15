import urllib
import urllib2



query_args = { 'q':'query string', 'foo':'bar' }
a = {'source':'test-source', 'message':''}
b = {'source':'test-source2', 'message':'did this work?'}
c = {'source':'test-source'}
d = {'source':''}



# data = urllib.urlencode(a)
data = urllib.urlencode(b)
# data = urllib.urlencode(c)
# data = urllib.urlencode(d)
url = 'http://heartbeat01.herokuapp.com/beats.php'
req = urllib2.Request(url, data)
response = urllib2.urlopen(req)
d = response.read()
print d

