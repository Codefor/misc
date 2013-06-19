#ifndef _BITMAP_H_   
#define _BITMAP_H_  

#define BITMAP_SIZE 150

typedef struct bitmap{
    unsigned char*  p;
    int             size;
    int             base;
}bitmap;

/* 
 *功能：初始化bitmap 
 *参数： 
 *size：bitmap的大小，即bit位的个数 
 *start：起始值 
 *返回值：0表示失败，1表示成功 
 */  
int bitmap_init(bitmap* b,int size, int start);  
  
/* 
 *功能：将值index的对应位设为1 
 *index:要设的值 
 *返回值：0表示失败，1表示成功 
 */  
int bitmap_set(bitmap* b,int index);  
 
/* 
 *功能：求两个bitmap的交集
 *返回值：求交后的bitmap
 */  
bitmap* bitmap_inter(bitmap* b1,bitmap* b2);  
 
/* 
 *功能：取bitmap第i位的值 
 *i：待取位 
 *返回值：-1表示失败，否则返回对应位的值 
 */  
inline int bitmap_get(bitmap* b,int i);  
  
/* 
 *功能：返回index位对应的值 
 */  
int bitmap_data(bitmap* b,int index);  
  
/*释放内存*/  
int bitmap_free(bitmap* b);  
  
#endif 
