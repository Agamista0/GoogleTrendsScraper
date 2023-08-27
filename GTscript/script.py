import pandas as pd                        
from pytrends.request import TrendReq
import mysql.connector
from mysql.connector import Error
import time


pytrend = TrendReq(hl='en-US', tz=360 )
print("the script is running")

# get the keywords from list 

df = pd.read_csv("keyword_list.csv")
Terms = df["Keywords"].values.tolist()
Tag = df["Tag"].values.tolist() 
Countries = df["Countries"].values.tolist()  

while True :
    for x in range(0,len(Terms)):
        time.sleep(5)
        keywords = [Terms[x]]               
        location = Tag[x]
        country=Countries[x]
        pytrend.build_payload(
        kw_list=keywords,
        timeframe='now 7-d',
        cat=0,

        )
        #get related queries
        
        related_queries = pytrend.related_queries()
        related_queries.values()
        allqueries = list(related_queries.values())[0]['rising']
        # conn with database 
        try:
            conn  = mysql.connector.connect(
                host    = 'db',
                user    = 'root',
                password  = 'root',
                database= 'google_trends')
            cur=conn.cursor()
            conn.commit()
            # chack on allqueries and send data from dataframs to database 
            if allqueries is not None :
                for (row,rs) in (allqueries.iterrows()):
                    query =str(rs[0])
                    value =str(rs[1])
                    if(len(value)>3):
                        value= ''.join((value[:-3],',',value[-3:]))
                    query="INSERT INTO `google_trends`.`queries` (`GrowingKayword`, `my_topic` , `Change`, `tag` , `countries`) value ('"+query+"','"+keywords[0]+"','"+value+"','"+location+"','"+country+"')"
                    cur.execute(query)
            else : 
                print(f'the related queries for {keywords} is zaro ')

            conn.commit()
            cur.close()
            print(f'i did send all data for {keywords}')

        except Error as e:
            print(f"The error '{e}' occurred")


    print("i'm sleeping ")
    time.sleep(3600)


    

