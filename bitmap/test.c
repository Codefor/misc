#include <stdio.h>   
#include <stdlib.h>   
#include <time.h>
#include "bitmap.h"   


void buildBITMAP(int a[],int length,bitmap** b){
    //pay attention to bitmap** b not bitmap* b
    *b = (bitmap*)malloc(sizeof(bitmap));
    bitmap_init(*b,BITMAP_SIZE, 0);  
    int i;
    for(i=0; i<length; i++){
        bitmap_set(*b,a[i]); 
    }
}

void display(bitmap* b){
    int i;
    for(i=0; i<BITMAP_SIZE; i++)  {  
        printf("%d", bitmap_get(b,i));  
    }
    printf("\n");
    for(i=0; i<BITMAP_SIZE; i++)  {  
        if(bitmap_get(b,i))  {
            printf("%d ", bitmap_data(b,i));  
        }
    }
    printf("\n");  
}

int main()  
{
    int a1[] = {5,8,7,6,3,1,10,78,56,34,23,12,43,54,65,76,87,98,89,100};  
    int a2[] = {5,8,7,6,3,1,10,78,56};
    bitmap* b1,*b2 = NULL;
    buildBITMAP(a1,sizeof(a1)/4,&b1);
    buildBITMAP(a2,sizeof(a2)/4,&b2);

    clock_t start = clock();
    bitmap* b3 = bitmap_inter(b1,b2);
    clock_t end = clock();
    printf("cost:%ld %d\n",end - start,CLOCKS_PER_SEC);

    //display(b1);
    //display(b2);
    //display(b3);
    printf("count1:%d\n",bitmap_count1(b1));
    printf("count1:%d\n",bitmap_count1(b2));
    printf("count1:%d\n",bitmap_count1(b3));

    bitmap_free(b1);  
    bitmap_free(b2);  
    bitmap_free(b3);  
    //scanf("%d",a1[0]);
    
    /**
    clock_t start = clock();
    int a,b=1;
    int i;
    for(i=0;i<1000000000;i++){
        a & b;
    }
    clock_t end = clock();
    printf("cost:%ld %d\n",end - start,CLOCKS_PER_SEC);
    */
    return 0;  
}
