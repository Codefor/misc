package main

import (
    "log"
    "fmt"
    "time"
)

const(
    BITMAPSIZE = 1024*1024*200
)

type Bitmap struct{
    Base    uint8  `sizeof the underlay type,say 8`
    BaseExp uint8  `log2(Base),exponent of the Base,say 3`
    Size    int64  `len(Bits),num of the underlay type,say BITMAPSIZE/Base`
    Bits    []int64 `bitmap holds the values,underlay-type:byte int64`
}

func NewBitmap()*Bitmap{
    var b = Bitmap{}
    b.Base = 64
    b.BaseExp = 8
    b.Size = BITMAPSIZE/int64(b.Base)
    b.Bits = make([]int64,b.Size)
    return &b
}

func(b *Bitmap)setBit(index int64)int{
    quo := index >> b.BaseExp
    remainder := uint8(index & int64(b.Base-1))
    if quo > b.Size{
        return -1
    }
    b.Bits[quo] |= (0x1<<remainder)
    return 0
}

func(b *Bitmap)getBit(index int64)int{
    quo := index >> b.BaseExp
    remainder := uint8(index & int64(b.Base-1))
    if quo > b.Size{
        return -1
    }

    res := b.Bits[quo] & (0x1<<remainder)
    if res >0{
        return 1
    }else{
        return 0
    }
}

func(b *Bitmap)inter(c *Bitmap)*Bitmap{
    var i int64
    for i =0;i<b.Size;i++{
        b.Bits[i] &= c.Bits[i]
    }
    return b
}

func(b *Bitmap)union(c *Bitmap)*Bitmap{
    var i int64
    for i=0;i<b.Size;i++{
        b.Bits[i] |= c.Bits[i]
    }
    return b
}

func(b *Bitmap)count1()int64{
    var (
        i int64
        p int64
        total int64
    )

    for i=0;i<b.Size;i++{
        p = int64(b.Bits[i])
        for p >0{
            total += 1
            p = p & (p-1)
        }
    }
    return total
}

func main(){
    log.SetFlags(23)
    b := NewBitmap()
    c := NewBitmap()

    for _,v:= range []int64{5,8,7,6,3,1,10,19}{
        b.setBit(v)
    }

    for _,v:= range []int64{5,8,7,6,3,1}{
        c.setBit(v)
    }

    a := NewBitmap()
    t:= time.Now()
    a.union(b).inter(c)
    log.Println(time.Since(t))
    for i:=0;i<20;i++{
        fmt.Print(b.getBit(int64(i)))
    }
    fmt.Println()
    for i:=0;i<20;i++{
        fmt.Print(c.getBit(int64(i)))
    }
    fmt.Println()
    for i:=0;i<20;i++{
        fmt.Print(a.getBit(int64(i)))
    }
    fmt.Println()
    fmt.Println(a.count1())
    fmt.Println()
}
