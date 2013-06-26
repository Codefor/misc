def m2n(m,n,input):
    #from m to n
    map = ['0','1','2','3','4','5','6','7','8','9',
           'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
           'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
           '/','~']
    tmp = range(len(input))
    for i in range(len(input)):
        tmp[i] = map.index(input[i])
    input = tmp

    output = []
    res = []
    while len(input) >0:
        total = 0
        for i in input:
            total = int(int(i) + total* m)
            res.append(total / n)
            total = total % n

        output.append(total)
        j = 0
        while j < len(res):
            if res[j] != 0:
                break
            j += 1
        input = res[j:]

        res = []
    output.reverse()

    for i in range(len(output)):
        output[i] = map[output[i]]

    return "".join(output)

#demo
s = m2n(10,64,"1372164962363491711144565762543")
print len(s),s
s1 = m2n(64,2,s)
print len(s1),s1
