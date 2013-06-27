package main

import "bytes"
import "log"

func main(){
    log.Println(m2n(64,10,"ZY4eMQ2qFcP/xIh3UcZ"))
    log.Println(m2n(10,64,"20110423215600563210173308035411215"))
}

func m2n(m,n int,input string)string{
    nummap := []byte{'0','1','2','3','4','5','6','7','8','9',
                'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
                'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
                '/','~',
            }
    tmp := make([]int ,len(input))
    for idx,char := range input{
        tmp[idx] = bytes.IndexByte(nummap,byte(char))
    }

    var (
        output []int
        res []int
        s []byte
    )

    for len(tmp) > 0{
        total := 0
        for _,v := range tmp{
            total = v + total * m
            res = append(res,total/n)
            total = total % n
        }
        output = append(output,total)
        j := 0
        for j < len(res){
            if res[j] != 0{
                break
            }
            j ++
        }
        tmp = res[j:]
        res = res[:0]
    }

    for i:=len(output)-1;i>=0;i--{
        s = append(s,nummap[output[i]])
    }

    return string(s)
}
