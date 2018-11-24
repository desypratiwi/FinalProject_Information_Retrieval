#!/usr/bin/python

import MySQLdb

# Open database connection
db = MySQLdb.connect("localhost","gokil","gokil","sehat_doc" )

# prepare a cursor object using cursor() method
cursor = db.cursor()

# Prepare SQL query to INSERT a record into the database.
sql = """INSERT INTO tb_mst_penyakit(judul,
         url_page_ori)
         VALUES ('test','test.com')"""
try:
   # Execute the SQL command
   cursor.execute(sql)
   # Commit your changes in the database
   db.commit()
except:
   # Rollback in case there is any error
   db.rollback()

# disconnect from server
db.close()