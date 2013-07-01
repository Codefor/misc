#include <stdio.h>   
#include <stdlib.h>   
#include <string.h>   
#include "bitmap.h"   
  
int bitmap_init(bitmap* b, int size, int start){  
    b->p = (unsigned char *)malloc((size/8+1)*sizeof(char));  
    if(b->p == NULL)  return 0;  
    b->base = start;  
    b->size = size/8+1;  
    memset(b->p , 0x0, b->size);  
    return 1;  
}
  
int bitmap_set(bitmap* b,int index)  
{
    int quo = (index-b->base) >> 3 ;  
    int remainder = (index-b->base)&7;  
    unsigned char x = (0x1<<remainder);  
    if( quo > b->size)  
        return 0;  
    b->p[quo] |= x;  
    printf("%d %d %d\n",index,quo,remainder);
    return 1;   
}  
  
inline int bitmap_get(bitmap* b,int i)  
{  
    int quo = (i)>>3 ;  
    int remainder = (i)&7;  
    unsigned char x = (0x1<<remainder);  
    unsigned char res;  
    if( quo > b->size)  
        return -1;  
    res = b->p[quo] & x;  
    return res > 0 ? 1 : 0;   
}  

//intersection 
bitmap* bitmap_inter(bitmap* b1,bitmap* b2)  
{  
    bitmap* b = (bitmap*)malloc(sizeof(bitmap));
    bitmap_init(b,BITMAP_SIZE, 0);
    int i;
    for(i=0;i<b->size;i++){
        b->p[i] = (b1->p[i] & b2->p[i]);
    }
    return b;
}

int bitmap_data(bitmap* b,int index)  
{  
    return (index + b->base);  
}  
  
int bitmap_free(bitmap* b)  
{  
    free(b->p);  
    free(b);  
    return 0;
}

int bitmap_count1(bitmap* b){
    int total = 0;
    int a = 0;
    int i;
    for(i=0;i<b->size;i++){
        a = (int)(b->p[i]);
        while(a){
            total += 1;
            a = a & (a-1);
        }
    }
    return total;
}
